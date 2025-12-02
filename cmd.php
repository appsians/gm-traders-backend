<?php
exec('php artisan optimize:clear', $output);
echo "<pre>";
print_r($output);
echo "</pre>";
