/*
 *  Document   : formsValidation.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Forms Validation page
 */

var FormsValidation = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Initialize Form Validation */
            $('#form-validation').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                ignore: [], //HARUS PAKE INI AGAR validasi select-chosen dapat digunakan
                rules: {
                    tahun_akademik: {
                        required: true,
                        minlength: 9
                    },
                    kelompok_mk:{
                        required: true
                    },                  
                    id_gedung:{
                        required: true
                    },
                    semester:{
                        required: true
                    },
                    nama_mk:{
                        required: true
                    },                    
                    nama_lengkap:{
                        required: true,
                        minlength: 3
                    },                    
                    email:{
                        required: true,
                        email: true
                    },                    
                    singkatan: {required:true},
                    smtr: {required:true},
                    sks: {required:true},
                    kode_mk: {required:true},
                    status_dosen: {required:true},
                    upload_file: {required:true},
                    tanggal_masuk: {required:true},
                    npm: {required:true},
                    id_dosen_wali: {required:true},
                    jk: {required:true},
                    nama_kelas: {required:true},
                    tahun_kelas: {required:true},
                    id_dosen: {required:true},
                    hari: {required:true},
                    waktu: {required:true},
                    ruangan: {required:true},
                    quota: {required:true}

                },
                messages: {                    
                    tahun_akademik: {
                        required: 'Silahkan isi tahun akademik',
                        minlength: 'contoh penulisan: 2021/2022'
                    },
                    kelompok_mk: {
                        required: 'Kelompok mata kuliah harus diisi'
                    },
                    nama_mk: {
                        required: 'Nama mata kuliah harus diisi'
                    },
                    nama_lengkap: {
                        required: 'Nama lengkap harus diisi',
                        minlength: 'Minimal diisi 3 karakter'
                    },
                    singkatan: 'Singkatan harus diisi',
                    id_gedung: 'Silahkan pilih gedung terlebih dahulu',
                    semester: 'Pilih semester Ganjil atau Genap',
                    smtr: 'Semester harus diisi',
                    sks: 'SKS harus diisi',
                    kode_mk: 'Kode mata kuliah harus diisi',
                    status_dosen: 'Silahkan pilih status dosen',
                    email: 'Harus di isi alamat email yang valid',
                    upload_file: 'Silahkan pilih foto',
                    tanggal_masuk: 'Tanggal masuk harus diisi',
                    npm: 'NPM mahasiswa harus diisi',
                    id_dosen_wali: 'Silahkan tentukan dosen wali atau dosen pembimbing akademik',
                    jk: 'Jenis kelamin harus diisi',
                    nama_kelas: 'Nama kelas harus diisi',
                    tahun_kelas: 'Tahun harus diisi',
                    id_dosen: 'Silahkan pilih dosen pengampu',
                    hari: 'Hari harus diisi',
                    waktu: 'Waktu harus diisi',
                    ruangan: 'Ruangan harus diisi',
                    quota: 'Quota harus diisi'
                    
                }
            });

            // Initialize Masked Inputs
            // a - Represents an alpha character (A-Z,a-z)
            // 9 - Represents a numeric character (0-9)
            // * - Represents an alphanumeric character (A-Z,a-z,0-9)
            $('#masked_date').mask('99/99/9999');
            $('#masked_date2').mask('99-99-9999');
            $('#masked_phone').mask('(999) 999-9999');
            $('#masked_phone_ext').mask('(999) 999-9999? x99999');
            $('#masked_taxid').mask('99-9999999');
            $('#masked_ssn').mask('999-99-9999');
            $('#masked_pkey').mask('a*-999-a999');
        }
    };
}();