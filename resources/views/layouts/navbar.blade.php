<nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Welcome!</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <div class="message-center" style="display:none">
                                            <!-- Message -->
                                            @if(Auth::user()->hak_akses == 'User')
                                                <a href="{{route('home')}}">
                                            @elseif(Auth::user()->hak_akses == 'Admin Bigwarehouse')
                                                <a href="{{route('home')}}">
                                            @elseif((Auth::user()->hak_akses == 'Admin Eggwarehouse'))
                                                <a href="{{route('home')}}">
                                            @elseif((Auth::user()->hak_akses == 'Admin Premixwarehouse'))
                                                <a href="{{route('home')}}">
                                            @elseif((Auth::user()->hak_akses == 'Admin Gudangcabang'))
                                                <a href="{{route('home')}}">
                                            @elseif((Auth::user()->hak_akses == 'Admin Financewarehouse'))
                                                <a href="{{route('home')}}">
                                            @elseif((Auth::user()->hak_akses == 'Kasir'))
                                                <a href="{{route('home')}}">
                                            @elseif((Auth::user()->hak_akses == 'Produksi'))
                                                <a href="{{route('home')}}">
                                            @endif
                                                <div class="btn btn-success btn-circle"><i class="far fa-file"></i></div>
                                                <div class="mail-contnet">
                                                    <h5 id="jumlahreq">Request Baru</h5> <span class="mail-desc">Cek Sekarang!</span> <span class="time">{{date('H.i')}}</span>
                                                </div>
                                            </a>

                                        </div>
              </li>
              
              <li class="nav-item"> <a class="nav-link  waves-effect waves-light" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons users_single-02"><p>{{ Auth::user()->name }}</p></i></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                             </form>
                </li>
            </ul>
          </div>
        </div>
      </nav>