-- file ini dijalankan sekali saat DB volume pertama kali dibuat
-- contoh: buat tabel demo
CREATE TABLE IF NOT EXISTS demo_init (
  id INT AUTO_INCREMENT PRIMARY KEY,
  note VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO demo_init (note) VALUES ('DB initialized on first run');
