# Portofolio Pribadi — 1:1 Replikasi Nana Amoako
*Terinspirasi langsung oleh desain estetika editorial modern [Nana Amoako](https://www.nanaamoako.com/)*

Website portofolio statis berkinerja tinggi, berkelas editorial, modern, dan sepenuhnya interaktif dengan tipografi khas *ultra-bold sans*, floating frosted dock, dark/light mode, background wordcloud portrait morph dinamis, 5 baris horizontal infinite marquee peran, dan 3 room interaktif (*Engineer, Hire Me, Creative*).

---

## 📸 Fitur Utama (1:1 Persamaan dengan Nana Amoako)

1. **Typographic Word-Cloud Portrait & Hero Stage (`.c-hero`)**:
   - Judul raksasa berkelas editorial dengan tipografi khas **Syne 800** dan **Bricolage Grotesque**.
   - Canvas full-screen dengan algoritma sampling siluet kata (*word packing*): saat pengguna melakukan scroll, kata-kata bertransformasi secara dinamis dari ukuran raksasa (7x zoom) menyusut dan terpusat membentuk siluet potret wajah.
   - Efek crossfade mulus ke potret fotografi asli saat scroll mencapai 80%.
   - Efek pencahayaan interaktif berbasis kursor (*mouse radial distance falloff*).
   - Indikator animasi vertikal `SCROLL TO MEET ME` dan tombol pintas `Skip intro ↓`.

2. **Section "I AM A..." & 5 Baris Marquee Loop (`#after-hero`)**:
   - Pinned label **"I AM A"** di sisi kiri dengan transisi background gradient fade.
   - 5 baris marquee berjalan (*infinite loop*) horizontal dengan kecepatan dan arah yang berbeda:
     - **Baris 1 (Builder)**: *Software engineer, Full-stack engineer, Founder, CEO, Researcher, Product builder...* (46s)
     - **Baris 2 (Maker)**: *Photographer, Filmmaker, Video editor, Colour grader, Creative director, UI/UX designer, DJ...* (55s, reverse)
     - **Baris 3 (Thinker)**: *Writer, Civic essayist, Technical writer, Storyteller, Strategist...* (64s)
     - **Baris 4 (Leader)**: *Entrepreneur, Business owner, Marketer, Team lead, Award winner...* (73s, reverse)
     - **Baris 5 (Human)**: *Bandung native, Tech graduate, Chef, Faith-driven, Lifelong learner...* (82s)
   - Setiap pil peran (`.c-iam`) dapat diklik untuk membuka **Modal Peek Dialog** (`.c-peek-root`) yang menampilkan portofolio dan proyek terkait peran tersebut.
   - Tombol teks mono `Tap to see more` di kanan bawah.

3. **Section "CURRENTLY" (Aktivitas Terkini)**:
   - Kartu 3 kolom minimalis (*Building, Shooting / Creating, Learning*) dengan tautan panah diagonal `↗`.
   - Dilengkapi tanggal pembaruan otomatis (*updated 2026-10-28*).

4. **Section "THE MONTHLY UPDATE" (Spotlight)**:
   - Spotlight card berkelas editorial dengan tombol `Read it →`.
   - Grid 2 kolom dengan foto ruangan beresolusi tinggi, sinopsis singkat, dan tombol `All essays & letters →`.
   - Klik kartu langsung membuka modal pembaca esai interaktif.

5. **Section "EXPLORE ANOTHER SIDE OF ME" (3 Interactive Doors)**:
   - 3 kartu vertikal interaktif dengan efek *accordion flex-grow*:
     - `01 ENGINEER`: Me behind the laptop (Glow hijau `rgba(34, 197, 94, .5)`).
     - `02 HIRE ME`: Ventures & master CV (Glow kuning `rgba(250, 204, 21, .5)`).
     - `03 CREATIVE`: Photography, film & design (Glow biru `rgba(47, 111, 237, .55)`).
   - Saat kartu di-hover, kartu membesar (`flex-grow: 2.15`), gambar bertransisi dari grayscale ke warna penuh, dan sinopsis serta tombol CTA slide terbuka mulus.
   - Klik kartu untuk membuka modal komprehensif tiap kamar.

6. **Floating Bottom Dock (`.c-dock`) & Explore Expand**:
   - Dock melayang di tengah bawah (*frosted glass*) dengan logo, nama, pembatas, tautan kamar (*Engineer, Creative*), dan split pill *Hire me* (dengan green pulsing dot) + tombol download *CV*.
   - Saat pengguna scroll mendekati bagian *Explore another side of me*, dock membesar secara anggun (`[data-big="true"]`) dan label teks mengambang **EXPLORE ANOTHER SIDE OF ME** muncul di atasnya.
   - Otomatis menyembunyikan diri saat scroll cepat ke bawah dan muncul kembali saat berhenti atau scroll ke atas.

7. **Floating Left Quick Access (`.c-qa`) & Ambient Sound**:
   - Toolbar vertikal di sisi kiri dengan tombol buka/tutup (*layout icon*).
   - Tautan cepat dengan tooltip mengambang:
     - *Everything I've made* (Katalog semua proyek).
     - *Essays & letters* (Bacaan & tulisan bulanan).
     - *Commission me* (Formulir kolaborasi / hire me).
   - Pengubah tema instan (**Dark Mode / Light Mode**) dengan penyimpanan preferensi di `localStorage`.
   - Pemutar audio ambient berbasis **Web Audio API** yang mensintesiskan *harmonic chord swell* dan animasi equalizer equalizer bar saat aktif.

8. **Modal Peek Dialog (`.c-peek-root`)**:
   - Modal berarsitektur *spring physics animation* yang responsif untuk meninjau detail peran, proyek, esai bulanan, dan form kontak.

---

## 🚀 Cara Menjalankan Portofolio

Proyek ini dibangun menggunakan arsitektur web murni berkinerja tinggi (HTML5, Vanilla CSS3, dan Modern JavaScript):

### Menjalankan Server Lokal:
```bash
# Menggunakan Python
python -m http.server 3000

# Atau menggunakan Node.js npx
npx serve
```
Kemudian buka browser Anda di `http://localhost:3000`.

---

## 🛠️ Panduan Kustomisasi

Seluruh data portofolio dipusatkan di file **[`scripts/config.js`](file:///d:/PORTFOLIO/scripts/config.js)**:
- **`profile`**: Nama lengkap, bio, domisili, email, link CV.
- **`brandWords`**: Kata-kata identitas untuk siluet hero.
- **`roleCategories`**: 5 kategori baris peran untuk marquee.
- **`currently`**: Daftar aktivitas dan tautan terkini.
- **`monthlyUpdate`**: Judul, sinopsis, dan isi cerita bulanan.
- **`rooms`**: Detail 3 ruangan (*Engineer, Hire Me, Creative*).
- **`catalogWorks`**: Proyek dan portofolio untuk modal dialog.
