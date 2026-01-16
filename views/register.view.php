<?php require "views/components/header.php" ?>


<main class="auth-container">
    <h1>Reģistrācija</h1>
    <form id="registerForm">
        <input type="text" name="username" placeholder="Ievadi lietotājvārdu" required><br><br>
        <input type="password" name="password" placeholder="Ievadi paroli" required><br><br>
        <button type="submit">Izveidot</button>
    </form>
    <p>Esi jau reģistrējies? <a href="/login">Pieslēdzies</a></p>
</main>

<script>
const form = document.getElementById("registerForm");
form.addEventListener("submit", function(e){
    e.preventDefault();
    const data = new FormData(form);
    
    fetch("/register", {
        method: "POST",
        body: data
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.status === "success") {
            window.location.href = "/login";
        }
    });
});
</script>

<?php require "views/components/footer.php" ?>