<header class="row no-gutters">
	<div class="brand col-md-3">
		<a href="/">
			<img src="/img/brand/96.png" alt="Logo de SITUR Magdalena">
			<h1 class="sr-only">SITUR Cesar</h1>
		</a>
		
	</div>
	<div id="nav-bar-main" class="col-md">
		<div id="toolbar-main" class="row no-gutters justify-content-end align-items-center">
		    <a href="#content-main" id="goto-top" class="sr-only">Ir al contenido</a>
			<div id="socialNetworks-fixed">
			    <a href="https://twitter.com/siturcesar?lang=es" target="_blank" rel="noreferrer noopener" title="Ir a twitter"><span class="ion-social-twitter" aria-hidden="true"></span> <span class="sr-only">Twitter</span></a>
				<!--<a href="#" target="_blank" rel="noreferrer noopener" title="Ir a Facebook"><span class="ion-social-facebook" aria-hidden="true"></span> <span class="sr-only">Facebook</span></a>-->
				<a href="https://www.instagram.com/siturcesar/" target="_blank" rel="noreferrer noopener" title="Ir a Instagram"><span class="ion-social-instagram" aria-hidden="true"></span> <span class="sr-only">Instagram</span></a>    
			</div>
			
			<form name="searchMainForm" method="get" action="" class="form-inline">
			    <div class="form-group">
			        <label class="sr-only" for="searchMainTBox">Campo de búsqueda</label>
					<input type="text" id="searchMainTBox" name="search" maxlength="255" placeholder="¿Qué desea buscar?" required autocomplete="off"/>
					<button type="submit" title="Buscar"><span class="ion-search" aria-hidden="true"></span> <span class="sr-only">Buscar</span></button>    
			    </div>
				
			</form>
			<a href="#">Mapa del sitio</a>
			<form name="langForm" method="get" action="">
				<label class="sr-only" for="languange">Selección de idioma</label>
				<select id="languange" name="lang" onchange="this.form.submit();">
					<option value="es" selected>Español</option>
					<option value="en">Inglés</option>
				</select>
			</form>
			<a href="#"><span class="ion-person" aria-hidden="true"></span> <span class="d-none d-sm-inline">Iniciar sesión</span></a>
		</div>
		<div id="navbar-mobile" class="text-center">
            <button type="button" class="btn btn-block btn-primary" title="Menu de navegación"><span aria-hidden="true" class="ion-navicon-round"></span><span class="sr-only">Menú de navegación</span></button>
        </div>
		<div id="nav-menu-main">
			<nav role="navigation" id="nav-main">
                <ul role="menubar">
                    <li>
                        <a id="menu-inicio" role="menuitem" href="/">Inicio</a>
                    </li>
                    <li>
                        <a role="menuitem" href="#menu-visitarAlCesar" aria-haspopup="true" aria-expanded="false">Visita al Cesar</a>
                        <ul role="menu" id="menu-visitarAlCesar" aria-label="Visita al Cesar">
                            <li role="none">
                                <a role="menuitem" href="/quehacer">Qué hacer</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="/Experiencias">Experiencias</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="/PST">Proveedores de Servicios Turísticos</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a role="menuitem" href="#menu-estadisticas" aria-haspopup="true" aria-expanded="false">Estadísticas</a>
                        <ul role="menu" id="menu-estadisticas" aria-label="Estadísticas">
                            <li role="none">
                                <a role="menuitem" href="#">Turismo receptor</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="#">Turismo interno</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="#">Turismo emisor</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="#">Oferta turística</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="#">Empleo</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="#">Turismo sostenible</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a role="menuitem" href="#menu-publicaciones" aria-haspopup="true" aria-expanded="false">Publicaciones</a>
                        <ul role="menu" id="menu-publicaciones" aria-label="Publicaciones">
                            <li role="none">
                                <a role="menuitem" href="#">Noticias</a>
                            </li>
                            <li role="none">
                                <a role="menuitem" href="#">Eventos</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a id="menu-contacto" role="menuitem" href="#">Contáctenos</a>
                    </li>
                </ul>
            </nav>
		</div>
	</div>
</header>