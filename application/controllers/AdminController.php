<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Admin;
use application\lib\Upload;

/**
 * @property Admin model
 */
class AdminController extends Controller
{

    private const ADMIN_RESOURCES_DIR = '/public/admin_resources/';
    private const IS_COOKIE_AUTH = false; // true продлевает срок сессии юзера за счет сохранения токена в cookies
    protected array $url;

    public function __construct($route)
    {
        parent::__construct($route);
        $this->url = explode('/', $_SERVER['REQUEST_URI']);
        $this->view->baseUrl = $this->url[1];
        if ($route['restricted']) {
            if (!$this->checkAuthorization()) {
                header('Location: /' . $this->view->baseUrl . '/login');
                exit;
            }
            $this->view->layout = 'admin';
        } else {
            $this->view->layout = 'simple';
        }
        $this->view->config = $this->model->getConfig();
        if ($route['table']) {
            $this->view->section = $route['table'];
            $this->view->sectionName = $this->view->config[$route['table']]['navigation'];
        }
        if ($route['id'])
            $this->view->id = $route['id'];
        $this->view->title = $this->view->h1 = 'Панель администратора';
        $this->view->adminDir = self::ADMIN_RESOURCES_DIR;
    }

    public function loginAction()
    {
        $minutesFromLastTry = round((time() - $_SESSION['admin_last_time']) / 60);
        if ($_SESSION['admin_attempts'] > 3 && $minutesFromLastTry <= 5) {
            $this->view->error = 'Вход заблокирован на непродолжительное время из-за ввода неверных данных.';
            $this->view->locked = true;
        } elseif (!empty($_POST)) {
            $login = trim($_POST['login']);
            $password = trim($_POST['password']);
            $loginResult = $this->model->authorization($login, $password);
            if ($loginResult['isSuccess']) {
                $this->saveAuthorization($loginResult['data']['id']);
                header('Location: /' . $this->view->baseUrl);
                exit;
            } else {
                $this->view->error = $loginResult['message'];
                if ($minutesFromLastTry > 5)
                    $_SESSION['admin_attempts'] = 1;
                else
                    $_SESSION['admin_attempts']++;
                $_SESSION['admin_last_time'] = time();
            }
        }
        $this->view->title = 'Вход в панель администратора';
        $this->view->render();
    }

    private function saveAuthorization(int $admin_id)
    {
        $_SESSION['admin_id'] = $admin_id;
        if (!self::IS_COOKIE_AUTH)
            return;
        setcookie("token1", md5($admin_id));
        setcookie("token2", $this->model->getToken($admin_id));
    }

    private function checkAuthorization(): bool
    {
        if ($_SESSION['admin_id'])
            return true;
        if ($_COOKIE['token1'] && $_COOKIE['token2'])
            return $this->model->isAuthorizedByCookies($_COOKIE['token1'], $_COOKIE['token2']);
        return false;
    }

    public function logoutAction()
    {
        unset($_SESSION['admin_id']);
        unset($_COOKIE['token1']);
        unset($_COOKIE['token2']);
        header('Location: /' . $this->view->baseUrl . '/login');
        exit;
    }

    public function indexAction()
    {
        $this->view->render();
    }

    public function viewAction()
    {
        $this->view->h1 = $this->view->sectionName . ' - просмотр';
        $this->view->title = $this->view->sectionName . ' | Просмотр | ' . $this->view->title;
        $this->view->data = $this->model->getViewData($this->view->section);
        $this->view->mode = 'view';
        $this->view->render();
    }

    public function editAction()
    {
        if (empty($_POST)) {
            $this->view->h1 = $this->view->sectionName . ' - редактирование';
            $this->view->title = $this->view->sectionName . ' | Редактирование | ' . $this->view->title;
            $this->view->cssMainBlockClass = 'col-lg-7';
            $this->view->data = $this->model->getEditData($this->view->section, $this->view->id);
            $this->view->render();
        } else {
            $id = $this->model->saveRow($this->view->config[$this->view->section]['table'],
                $this->view->id,
                $this->view->config[$this->view->section]['edit']['fields'],
                $_POST,
                $this->uploadImages()
            );
            if ($id) {
                $this->deleteImages();
                $_SESSION['msg']['id'] = $id;
                $_SESSION['msg']['success'] = true;
            } else {
                $_SESSION['msg']['success'] = false;
            }
            header('Location: /' . $this->url[1] . '/view/' . $this->url[3]);
            exit;
        }
    }

    private function uploadImages(): array
    {
        $names = $extNames = [];
        foreach ($_FILES as $name => $file) {
            if (is_array($file['name'])) {
                for ($i = 0; $i < count($file['name']); $i++) {
                    $extFile = [
                        'name'      => $file['name'][$i],
                        'type'      => $file['type'][$i],
                        'tmp_name'  => $file['tmp_name'][$i],
                        'error'     => $file['error'][$i],
                        'size'      => $file['size'][$i],
                    ];
                    var_dump($i, $extFile);
                    $newName = $this->uploadImage($name, $extFile, false);
                    if ($newName)
                        $extNames[$name][] = $newName;
                }
            } else {
                $newName = $this->uploadImage($name, $file);
                if ($newName)
                    $names[$name] = $newName;
            }
        }
        return ['images' => $names, 'extImages' => $extNames];
    }

    private function uploadImage(string $name, array $file, bool $internalImage = true): string
    {
        $newName = '';
        $conf = $this->view->config[$this->view->section];
        $img_path = $_SERVER['DOCUMENT_ROOT'] . '/public/pictures/main/' . ($internalImage ? $conf['table'] :  $conf['edit']['fields'][$name]['targetTable']) . '/';
        $handle = new Upload($file);
        if ($handle->uploaded) {
            $newName = md5(uniqid(rand(), true));
            if ($_POST['oldImages'][$name])
                $this->deleteImageFiles($img_path, $_POST['oldImages'][$name]); // удаление предыдущей версии изображения
            foreach ($conf['edit']['fields'][$name]['resize'] as $k => $x) {
                if ($conf['edit']['fields'][$name]['crop'][$k]) {
                    $handle->image_y = $conf['edit']['fields'][$name]['crop'][$k];
                    $handle->image_ratio_crop = true;
                } elseif ($conf['edit']['fields'][$name]['fill'][$k]) {
                    $handle->image_y = $conf['edit']['fields'][$name]['fill'][$k];
                    $handle->image_ratio_fill = true;
                } else
                    $handle->image_ratio_y = true;
                $handle->image_resize = true;
                $handle->image_x = $x;
                $handle->image_convert = 'webp';
                $handle->webp_quality = 90;
                $handle->file_new_name_body = $newName . '-' . ($k + 1);
                $handle->process($img_path);
            }
        }
        $handle->clean();
        return $newName;
    }

    private function deleteImages(): void
    {
        if ($_POST['delete']) {
            $conf = $this->view->config[$this->view->section];
            $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/public/pictures/main/' . $conf['table'] . '/';
            foreach ($_POST['delete'] as $image) {
                $fileName = $_POST['oldImages'][$image];
                if ($fileName)
                    $this->deleteImageFiles($imgPath, $fileName);
            }
        }
    }

    private function deleteImageFiles(string $imgPath, ?string $fileName): void
    {
        if ($fileName) {
            $imgUrl = $imgPath . $fileName;
            foreach (glob($imgUrl . '*.*') as $deleteFile)
                unlink($deleteFile);
        }
    }

    public function deleterowAction(): void
    {
        if ($this->view->id && $this->view->section) {
            $mode = $this->url[5];
            if ($mode == 1) {
                $files = $this->model->getImageName($this->view->section, $this->view->id);
                $table = $this->url[3];
            } else {
                $files = $this->model->getImageNames($this->view->section, $this->view->id);
                $table = $this->view->config[$this->view->section]['table'];
            }
            if ($files) {
                foreach ($files as $fileName)
                    if ($fileName)
                        $this->deleteImageFiles('', $fileName);
            }
            $this->model->deleteRow($table, $this->view->id);
        }
    }

    /** Создает пользователя админки */
    public function newuserAction(): void
    {
        $this->model->createUser($this->route['login'], $this->route['password']);
        echo 'Новый пользователь добавлен в БД';
    }

}