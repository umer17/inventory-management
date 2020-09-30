<!-- NAVBAR-->

<header>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <nav class="navbar mb-5 navbar-expand-lg navbar-dark bg-dark ">
    <a href="home.php"> <img src="images/logo.png" class="text-center mx-auto " alt="Logo" width="20%" height="auto">
    </a>
       
        <div class="collapse navbar-collapse text-right float-right" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto text-right">
                <li class="nav-item active text-right">
                    <a class="nav-link text-right" onclick="logout()" href="#">Logout <span class="sr-only">(current)</span></a>
                </li>
               
            </ul>
           
        </div>
    </nav>
    <script type="text/javascript">
    function logout()
    {
        
            
            $.ajax({
                type: 'POST',
                url: 'controllers/formhandler.php',
                data: {
                    logout: 'logout',
                  
                },
                datatype: 'JSON',
                success: function(data) {
                   window.location="login.php"
                },
                error: function(error) {
                    console.log(error)
                },
            });
        
        }
       
        
    
</script>
</header>
<!--Main Navigation-->




<!--Main Layout-->