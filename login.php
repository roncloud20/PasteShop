<?php
$pagetitle = "Login to your account";
require_once('assets/header.php');

// Initializing variables
$email = $password = $emailError = $passwordError = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if($row['verified'] === 1) {
            if(password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['user_role'] = $row['user_role'];
                echo "<script>window.location.href = 'dashboard.php';</script>";
                // header("Location: dashboard.php");
            } else {
                echo "<h1>Invalid Login Credentials</h1>";
            }
        } else {
            echo "<h1>Account is not verified</h1>";
        }
    } else {
        echo "<h1>Invalid Login Credentials</h1>";
    }
}

?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
    <form action="" class="w-full max-w-md bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-white/20" method="post">
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-extrabold text-gray-900">Register Now</h2>
            <p class="text-gray-500 text-sm">Create new account</p>
        </div>

        <div class="space-y-4">
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" value="<?= $email ?>" />
                <span class="text-red-500"><?= $emailError ?></span>
            </div>

            <!-- Password -->
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="pass1" class="w-full px-4 py-3 rounded-lg border border-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" value="<?= $password ?>" />
                <span class="h-5 w-5 absolute cursor-pointer" style="top: 40px; right:10px" id="check1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                    </svg>
                </span>
                <span class="text-red-500"><?= $passwordError ?></span>
            </div>

            <!-- Submit -->
            <div>
                <input type="submit" value="Login" class="w-full bg-gradient-to-r from-blue-500 to-red-600 hover:from-blue-600 hover:to-red-700 text-white font-semibold py-3.5 rounded-lg duration-200 transform hover:scale-[1.01] shadow-md cursor-pointer" />
            </div>
        </div>
    </form>

</div>

<script>
    const check1 = document.querySelector('#check1');
    const pass1 = document.querySelector("#pass1");

    check1.addEventListener('click', (e) => {
        check1.classList.toggle('show');
        if (check1.classList.contains('show')) {
            pass1.type = 'text';
            check1.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6"><path d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" /><path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" /><path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" /></svg>';
        } else {
            pass1.type = 'password';
            check1.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" /><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" /></svg>'
        }
    })
</script>
