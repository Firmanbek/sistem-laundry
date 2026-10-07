<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Peta akses per role.
     * '*' = semua fungsi, atau daftar fungsi yang diizinkan.
     * Tambahkan controller baru di sini setiap kali membuat fitur baru.
     *
     * @var array<string, array<string, string|array<string>>>
     */
    protected array $petaAkses = [
        'admin' => [
            'Pelanggan' => '*',
            'Layanan' => '*',
            'Transaksi' => '*',
            'Pembayaran' => '*',
        ],
        'pemilik' => [
            'Transaksi' => ['index', 'view'],
            'Pembayaran' => ['index', 'view'],
            'Laporan' => '*',
            'Pengaturan' => '*',
            'Users' => '*',
        ],
    ];

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');

        $this->loadComponent('Flash');
    }

    /**
     * Memeriksa hak akses berdasarkan role sebelum setiap halaman dibuka.
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Belum login: biarkan komponen Authentication yang mengarahkan ke halaman login
        $identity = $this->Authentication->getIdentity();
        if ($identity === null) {
            return;
        }

        $role = (string)$identity->get('role');
        $controller = (string)$this->request->getParam('controller');
        $action = (string)$this->request->getParam('action');

        // Beranda, login, dan logout boleh dibuka semua role
        if (in_array($controller, ['Pages', 'Dashboard'], true)) {
            return;
        }
        if ($controller === 'Users' && in_array($action, ['login', 'logout'], true)) {
            return;
        }

        $diizinkan = $this->petaAkses[$role][$controller] ?? null;
        $boleh = $diizinkan === '*'
            || (is_array($diizinkan) && in_array($action, $diizinkan, true));

        if (!$boleh) {
            $this->Flash->error('Anda tidak punya akses ke halaman itu.');

            return $this->redirect('/');
        }
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        try {
            $outlet = $this->fetchTable('Pengaturan')->find()->first();
            $this->set('namaOutlet', $outlet?->nama_outlet ?: 'Sistem Laundry');
        } catch (\Throwable $e) {
            $this->set('namaOutlet', 'Sistem Laundry');
        }
    }

}