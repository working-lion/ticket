<header>
    <div class="header_top">
        <div class="container clear">
            <?php if(User::isAdmin()):?>
            <ul class="menu admin_header_menu left">
                <li><a href="/admin"><i class="fa fa-cog" aria-hidden="true"></i>
                        Панель администратора</a></li>
            </ul>
            <?php endif; ?>
            <ul class="menu user_menu right">                                    
                <?php if (User::isGuest()): ?>                                        
                <li><a href="/user/login/" class="login"><i class="fa fa-lock" 
                    aria-hidden="true"></i>Вход</a></li>
                <li><a href="/user/register/" class="reg"><i class="fa fa-user"></i>
                    Регистрация</a></li>
                <?php else: ?>
                <li><a href="/cabinet/"><i class="fa fa-user"></i>Аккаунт</a></li>                                    
                <li><a href="/user/logout/"><i class="fa fa-unlock"></i>Выход</a></li>                                        
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="container">
        <a href="/"class="logo">Ticket.смотримсайт.рф</a>
    </div>
</header>

