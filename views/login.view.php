<?php require "views/components/header.php" ?>


<main class="auth-container">
    <h1>Ienākt</h1>
    <form id="loginForm">
        <input type="text" name="username" placeholder="Lietotājvārds" required><br><br>
        <input type="password" name="password" placeholder="Parole" required><br><br>
        <button type="submit">Ienākt</button>
    </form>
    <p>Vai nēsi reģistrējies? <a href="/register">Reģistrējies šeit</a></p>
</main>

<script>
const form = document.getElementById("loginForm");
form.addEventListener("submit", function(e){
    e.preventDefault();
    const data = new FormData(form);
    
    fetch("/login", {
        method: "POST",
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success") {
            window.location.href = "/";
        } else {
            alert(data.message);
        }
    });
});
</script>

<?php require "views/components/footer.php" ?>