<?php
echo phpversion(); // 5.2.4-2ubuntu5.2
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        dl('php_zip.dll');
    } else {
        dl('zip.so');
    }
?><br />

<?php
print_r(get_loaded_extensions());
?><br />
<?php
print_r(get_extension_funcs("zlib"));
?>