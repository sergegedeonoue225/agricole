<!-- menu.php -->
<div id="sidebar" class="sidebar">
    <div class="menu-item">
        <a style="text-decoration: none; color: black;" >MENU</a>
    </div>
    <span class="close-btn" id="close-btn">&times;</span>
    <div class="menu-item">
        <a style="text-decoration: none; color: #004f32;" href="dashboard.php">TABLEAU DE BORD</a>
    </div>
    <div class="menu-item">
        <a style="text-decoration: none; color: #004f32;" href="profil.php">MON PROFIL</a>
    </div>
    <div class="menu-item">
        <a style="text-decoration: none; color: #004f32;" href="virement.php">EFFECTUER UN VIREMENT</a>
    </div>
    <div class="menu-item">
        <a style="text-decoration: none; color: #004f32;" href="#">MES OPERATIONS</a>
    </div>
    <div class="menu-item">
        <a style="text-decoration: none; color: #004f32;" href="#">GERER MA CARTE</a>
    </div>
    <div class="menu-item">
        <a style="text-decoration: none; color: #004f32;" href="#">ACCEDEZ A MES E-DOCUMENTS</a>
    </div>
    <div class="menu-item">
        <a style="text-decoration: none; color: #004f32;" href="deconnexion.php">SE DECONNECTER</a>
    </div>
</div>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });
    document.getElementById('close-btn').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('active');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
