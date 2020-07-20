<?php
    
    //Bahasa Indonesia
    function translateId(){
        tt("Home", "Beranda");
        tt("Dashboard", "Dasbor");
        tt("Logout", "Keluar");
        tt("Login", "Masuk");
        tt("Register", "Daftar");
        tt("About", "Tentang");
        tt("Welcome", "Selamat datang");
        tt("Incorrect email and/or password!", "Email dan/atau password salah!");
        tt("This email address is already registered. Try to use another email.", "Alamat email sudah terdaftar. Coba gunakan email lain.");
        tt("Thank you for registering!", "Terima kasih, Anda sudah terdaftar!");
        tt("You did not fill all the fields. Please try again.", "Semua harus diisi.");
        tt("Name/Nickname", "Nama/Panggilan");
        tt("Phone Number", "Nomor HP");
        tt("*Include your country code before your phone number like this: 6590611234", "*Masukkan nomor HP dengan kode negara seperti ini misalnya: 6290611234");
        tt("Address", "Alamat");
        tt("Good bye!", "Sampai jumpa!");
        tt("Add", "Tambah");
        tt("Title", "Judul");
        tt("Price", "Harga");
        tt("Description", "Keterangan");
        tt("Submit", "Tambahkan");
        tt("Choose your primary product photo:", "Pilih gambar utama produk:");
        tt("Products", "Produk");
        tt("Click to edit one of your published products.", "Klik pada gambar untuk mengubah data produk.");
        tt("Current product photo (Click if you want to replace it)", "Foto produk saat ini (Klik jika Anda ingin menggantinya)");
        tt("You don't have any product yet.", "Anda belum menambahkan produk.");
        tt("Profile", "Profil");
        tt("Are you willing to be contacted via WhatsApp chat?", "Apakah Anda bersedia dihubungi via WhatsApp?");
        tt("This option will enable WhatsApp chat button on your products.", "Jika Anda pilih Ya maka akan muncul tombol chat via WhatsApp pada produk Anda.");
        tt("Update", "Perbarui");
        tt("Yes", "Ya");
        tt("No", "Tidak");
        tt("Messages", "Pesan");
        tt("Message", "Pesan");
        tt("There is no message yet.", "Belum ada pesan masuk.");
        tt("Chat on WhatsApp", "Chat di WhatsApp");
        tt("Send Message", "Kirim Pesan");
        tt("Products added by", "Produk ditambahkan oleh");
        tt("Added by", "Ditambahkan oleh");
        tt("from", "dari");
        tt("Just for", "hanya");
        tt("Coming soon!", "Segera hadir!");
        tt("Messaging", "Kirim Pesan");
        tt("You are sending a message to", "Anda sedang mengirim pesan kepada");
        tt("You will get the response by email", "Anda akan mendapatkan jawaban pesan via email");
        tt("Enter your email address", "Masukkan alamat email Anda");
        tt("Continue", "Lanjut");
        tt("Type your message here", "Tulis pesan Anda di sini");
        tt("Your message has been received. The seller will contact you via email soon", "Pesan Anda telah terkirim. Penjual akan menghubungi Anda via email.");
        tt("You got a new message from", "Anda mendapatkan pesan baru dari");
        tt("Hi, I came across this link", "Halo, saya melihat produk Anda di link ini");
        tt("and I want to ask some questions", "dan saya ingin bertanya");
        tt("Loading", "Tunggu sejenak");
        tt("To start replying chat messages, click one of items on the left panel", "Untuk membalas chat, klik salah satu pesan di sebelah kiri");
        tt("Chat Now", "Chat Sekarang");
        tt("The seller is", "Penjual sedang");
        tt("Enter your email to continue", "Masukkan alamat email Anda untuk melanjutkan");
        tt("Chats", "Chat");
        tt("Loading chat", "Memuat chat");
        tt("Date", "Tanggal");
        tt("Sender", "Pengirim");
        tt("Back", "Kembali");
        tt("Product ID", "ID Produk");
        tt("Message ID", "ID Pesan");
        tt("Your reply message will be mailed to", "Pesan Anda akan dikirim ke alamat email");
        tt("Edit Product", "Perbarui Produk");
        tt("Product has been successfully updated", "Produk berhasil diperbarui");
        tt("Incomplete information", "Data tidak lengkap.");
        tt("to view this product", "untuk melihat produk ini");
        tt("here", "di sini");
        tt("Click", "Klik");
        tt("to delete it", "untuk menghapusnya");
        tt("Product has been successfully deleted", "Produk berhasil dihapus");
        tt("Gallery", "Galeri");
        tt("Great! New product has been added", "Produk baru berhasil ditambahkan");
        tt("You did not add any image yet", "Anda belum menambahkan gambar apapun");
        tt("New image has been added", "Gambar baru berhasil ditambahkan");
        tt("Add new Image", "Tambahkan gambar baru");
        tt("Choose any image file and click Sumbit to upload", "Pilih gambar yang Anda inginkan lalu klik Tambahkan");
        tt("What are you looking for?", "Apa yang Anda cari?");
        tt("Find it!", "Temukan!");
        tt("Search results", "Hasil pencarian");
        tt("Nothing found", "Tidak ditemukan apapun");
        tt("Delete this image", "Hapus gambar ini");
        tt("You have", "Anda punya");
        tt("images in your Gallery. You can upload up to", "gambar di Galeri. Anda bisa mengunggah hingga");
        tt("images to this Gallery", "gambar ke Galeri ini");
        tt("Image removed", "Gambar telah dihapus");
        tt("Add more images from Gallery", "Tambah gambar lainnya dari Galeri");
        tt("Click to add more images from Gallery", "Klik untuk menambahkan gambar lain dari Galeri");
        tt("Close", "Tutup");
        tt("Remove", "Singkirkan");
        tt("This image is already used", "Gambar ini sudah dipakai");
        tt("More images", "Gambar lainnya");
    }
    
    $rawword;
    function uilang($txt){
        global $defaultlang;
        global $rawword;
        $rawword = $txt;
        switch($defaultlang){
            case "id" :
                translateId();
                break;
            default :
                echo $txt;
                break;
        }
    }
    
    function tt($txt1, $txt2){
        global $defaultlang;
        global $rawword;
        if($rawword == $txt1){
            echo $txt2;
        }
    }
    
?>