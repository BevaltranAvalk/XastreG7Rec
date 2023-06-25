<?php 
session_start();

// Limpar todas as variáveis de sessão
session_unset();

// Destruir a sessão
session_destroy();

// Redirecionar o usuário para a página de login ou para qualquer outra página desejada
header("Location: login.php");
exit;