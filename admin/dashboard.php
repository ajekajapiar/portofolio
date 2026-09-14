<?php

session_start();

echo "DASHBOARD TEST BERHASIL";

echo "<br>";

echo "Admin ID: ";
echo $_SESSION['admin_id'] ?? 'tidak ada';

echo "<br>";

echo "Username: ";
echo $_SESSION['admin_username'] ?? 'tidak ada';