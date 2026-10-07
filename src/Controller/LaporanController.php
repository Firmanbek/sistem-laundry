<?php
declare(strict_types=1);

namespace App\Controller;

class LaporanController extends AppController
{
    public function index()
    {
        $dari = (string)$this->request->getQuery('dari', date('Y-m-01'));
        $sampai = (string)$this->request->getQuery('sampai', date('Y-m-d'));
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dari)) {
            $dari = date('Y-m-01');
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $sampai)) {
            $sampai = date('Y-m-d');
        }
        if ($sampai < $dari) {
            $sampai = $dari;
        }
        $awal = $dari . ' 00:00:00';
        $akhir = $sampai . ' 23:59:59';

        $pembayaran = $this->fetchTable('Pembayaran')->find()
            ->where(['tanggal_pembayaran >=' => $awal, 'tanggal_pembayaran <=' => $akhir])
            ->all();

        $totalMasuk = 0.0;
        $perMetode = [];
        $perHari = [];
        foreach ($pembayaran as $p) {
            $jumlah = (float)$p->jumlah_bayar;
            $metode = (string)$p->metode_pembayaran;
            $hari = $p->tanggal_pembayaran->format('Y-m-d');
            $totalMasuk += $jumlah;
            $perMetode[$metode] = ($perMetode[$metode] ?? 0) + $jumlah;
            $perHari[$hari] = ($perHari[$hari] ?? 0) + $jumlah;
        }
        arsort($perMetode);
        krsort($perHari);

        $notaPeriode = $this->fetchTable('Transaksi')->find()
            ->contain(['Pelanggan', 'Pembayaran'])
            ->where(['Transaksi.tanggal_masuk >=' => $awal, 'Transaksi.tanggal_masuk <=' => $akhir])
            ->orderBy(['Transaksi.id' => 'DESC'])
            ->all();

        $totalTagihan = 0.0;
        $piutang = 0.0;
        foreach ($notaPeriode as $n) {
            $totalTagihan += (float)$n->total_harga;
            $piutang += $n->kekurangan;
        }

        $jumlahBayar = $pembayaran->count();
        $this->set(compact('dari', 'sampai', 'totalMasuk', 'jumlahBayar', 'perMetode', 'perHari', 'notaPeriode', 'totalTagihan', 'piutang'));
    }
}
