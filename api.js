/*
REST API untuk menampilkan data pasien result dari join semua tabel
Endpoint: GET /api/pasien
Query params (opsional):
  - tgl_awal (YYYY-MM-DD)
  - tgl_akhir (YYYY-MM-DD)
  - nama_pasien
  - nama_dokter

Contoh penggunaan: GET /api/pasien?nama_pasien=Iwan&tgl_awal=2025-01-01&tgl_akhir=2025-01-31
*/

require('dotenv').config();
const express = require('express');
const mysql = require('mysql2/promise');
const app = express();
const PORT = process.env.PORT || 3000;

// Buat connection pool
const pool = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASS,
  database: process.env.DB_NAME,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

app.get('/api/pasien', async (req, res) => {
  try {
    const { tgl_awal, tgl_akhir, nama_pasien, nama_dokter } = req.query;
    let sql = `
      SELECT
        r.no_registrasi,
        p.nama_pasien,
        po.nm_poli       AS poli_tujuan,
        d.nm_dokter,
        pp.ket_diagnosa,
        r.tgl_registrasi
      FROM registrasi_pasien r
      JOIN pasien p  ON r.no_rekam_medis = p.no_rekam_medis
      JOIN poli po   ON r.id_poli_tujuan  = po.id_poli
      JOIN periksa_pasien pp ON pp.no_rekam_medis = r.no_rekam_medis
      JOIN dokter d ON pp.kd_dokter      = d.kd_dokter
      WHERE 1=1`;

    const params = [];
    if (tgl_awal && tgl_akhir) {
      sql += ' AND r.tgl_registrasi BETWEEN ? AND ?';
      params.push(tgl_awal, tgl_akhir);
    }
    if (nama_pasien) {
      sql += ' AND p.nama_pasien LIKE ?';
      params.push(`%${nama_pasien}%`);
    }
    if (nama_dokter) {
      sql += ' AND d.nm_dokter = ?';
      params.push(nama_dokter);
    }

    const [rows] = await pool.query(sql, params);
    res.json({ success: true, data: rows });
  } catch (err) {
    console.error(err);
    res.status(500).json({ success: false, message: 'Server error' });
  }
});

app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
