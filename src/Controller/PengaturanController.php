<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\PasswordHasher\DefaultPasswordHasher;

class PengaturanController extends AppController
{
    public function index()
    {
        $tabel = $this->fetchTable('Pengaturan');
        $outlet = $tabel->find()->first() ?? $tabel->newEmptyEntity();

        if ($this->request->is(['post', 'put', 'patch'])) {
            $outlet = $tabel->patchEntity($outlet, $this->request->getData());
            if ($tabel->save($outlet)) {
                $this->Flash->success('Pengaturan outlet disimpan.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Pengaturan gagal disimpan. Periksa isian.');
        }

        $users = $this->fetchTable('Users')->find()->orderBy(['role' => 'ASC', 'nama' => 'ASC'])->all();
        $idSaya = (int)$this->request->getAttribute('identity')->getIdentifier();
        $this->set(compact('outlet', 'users', 'idSaya'));
    }

    public function editAkun($id = null)
    {
        $users = $this->fetchTable('Users');
        $akun = $users->get($id);
        $diriSendiri = (int)$this->request->getAttribute('identity')->getIdentifier() === (int)$akun->id;

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $nama = trim((string)($data['nama'] ?? ''));
            $username = trim((string)($data['username'] ?? ''));
            $baru = (string)($data['password_baru'] ?? '');
            $konfirmasi = (string)($data['konfirmasi'] ?? '');
            $lama = (string)($data['password_lama'] ?? '');

            $galat = null;
            if ($nama === '' || $username === '') {
                $galat = 'Nama dan username wajib diisi.';
            } elseif (preg_match('/\s/', $username)) {
                $galat = 'Username tidak boleh mengandung spasi.';
            } elseif ($users->find()->where(['username' => $username, 'id !=' => $akun->id])->count() > 0) {
                $galat = 'Username sudah dipakai akun lain.';
            } elseif ($baru !== '' && strlen($baru) < 6) {
                $galat = 'Kata sandi baru minimal 6 karakter.';
            } elseif ($baru !== $konfirmasi) {
                $galat = 'Konfirmasi kata sandi tidak sama.';
            } elseif ($diriSendiri && !(new DefaultPasswordHasher())->check($lama, (string)$akun->password)) {
                $galat = 'Kata sandi lama salah.';
            }

            $akun->nama = $nama;
            $akun->username = $username;

            if ($galat !== null) {
                $this->Flash->error($galat);
            } else {
                if ($baru !== '') {
                    $akun->password = $baru;
                }
                if ($users->save($akun)) {
                    if ($diriSendiri) {
                        $this->Authentication->logout();
                        $this->Flash->success('Akunmu diperbarui. Silakan masuk kembali.');

                        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                    }
                    $this->Flash->success('Akun ' . $akun->username . ' diperbarui.');

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error('Akun gagal disimpan.');
            }
        }
        $this->set(compact('akun', 'diriSendiri'));
    }
}
