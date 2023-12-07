<!-- FOOTER -->
<footer>
    <div class="container-lg">
        <div class="row gy-3">
            <div class="col-md-6 col-lg-3">
                <div class="footerlogo">
                    <img src="{{ asset('assets/images/footer-logo.png') }}" alt="logo">
                </div>
            </div>
            <div class="col-md-12 col-lg-6 order-2 order-md-3 order-lg-2">
                <h4>Quick Links</h4>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a href="{{route('front.main-feed')}}" class="nav-link">Main feed</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.open-stock-trades')}}" class="nav-link">Open stock trades</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.closed-stock-trades')}}" class="nav-link">Closed Stock Trades</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.open-options-trades')}}" class="nav-link">Open Options Trades</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.closed-options-trades')}}" class="nav-link">Closed Options Trades</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a href="{{ route('front.home') }}" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">How it works & Strategy</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Start trading</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 order-3 order-md-2 order-lg-3">
                <h4>Contact Us</h4>
                <ul class="navbar-nav flex-column">
                    <li>
                        <a href="tel:(111) 111 1111" class="nav-link nav-item d-flex gap-2 align-items-center">
                            <span class="svg-26">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                    <path d="M22.5008 21.1575C22.5008 21.5475 22.4142 21.9483 22.23 22.3383C22.0458 22.7283 21.8075 23.0967 21.4933 23.4433C20.9625 24.0283 20.3775 24.4508 19.7167 24.7217C19.0667 24.9925 18.3625 25.1333 17.6042 25.1333C16.4992 25.1333 15.3183 24.8733 14.0725 24.3425C12.8267 23.8117 11.5808 23.0967 10.3458 22.1975C9.1 21.2875 7.91917 20.28 6.7925 19.1642C5.67667 18.0375 4.66917 16.8567 3.77 15.6217C2.88167 14.3867 2.16667 13.1517 1.64667 11.9275C1.12667 10.6925 0.866669 9.51167 0.866669 8.38501C0.866669 7.64834 0.996669 6.94418 1.25667 6.29418C1.51667 5.63334 1.92834 5.02667 2.5025 4.48501C3.19584 3.80251 3.95417 3.46667 4.75584 3.46667C5.05917 3.46667 5.3625 3.53167 5.63334 3.66167C5.915 3.79167 6.16417 3.98667 6.35917 4.26834L8.8725 7.81084C9.0675 8.08168 9.20834 8.33084 9.30584 8.56918C9.40334 8.79668 9.4575 9.02418 9.4575 9.23001C9.4575 9.49001 9.38167 9.75001 9.23 9.99917C9.08917 10.2483 8.88334 10.5083 8.62334 10.7683L7.8 11.6242C7.68084 11.7433 7.62667 11.8842 7.62667 12.0575C7.62667 12.1442 7.6375 12.22 7.65917 12.3067C7.69167 12.3933 7.72417 12.4583 7.74584 12.5233C7.94084 12.8808 8.27667 13.3467 8.75334 13.91C9.24084 14.4733 9.76084 15.0475 10.3242 15.6217C10.9092 16.1958 11.4725 16.7267 12.0467 17.2142C12.61 17.6908 13.0758 18.0158 13.4442 18.2108C13.4983 18.2325 13.5633 18.265 13.6392 18.2975C13.7258 18.33 13.8125 18.3408 13.91 18.3408C14.0942 18.3408 14.235 18.2758 14.3542 18.1567L15.1775 17.3442C15.4483 17.0733 15.7083 16.8675 15.9575 16.7375C16.2067 16.5858 16.4558 16.51 16.7267 16.51C16.9325 16.51 17.1492 16.5533 17.3875 16.6508C17.6258 16.7483 17.875 16.8892 18.1458 17.0733L21.7317 19.6192C22.0133 19.8142 22.2083 20.0417 22.3275 20.3125C22.4358 20.5833 22.5008 20.8542 22.5008 21.1575Z" stroke="currentColor" stroke-width="1.2" stroke-miterlimit="10"/>
                                    <path d="M18.7417 11.0501C18.7417 10.4001 18.2325 9.40342 17.4742 8.59092C16.7809 7.84342 15.86 7.25842 14.95 7.25842" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M22.5334 11.05C22.5334 6.85751 19.1425 3.46667 14.95 3.46667" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            (111) 111 1111
                        </a>
                    </li>
                    <li>
                        <a href="mailto:clientservices@trading.com" class="nav-link nav-item d-flex gap-2 align-items-center">
                            <span class="svg-26">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                    <path d="M18.4167 22.2083H7.58332C4.33332 22.2083 2.16666 20.5833 2.16666 16.7916V9.20829C2.16666 5.41663 4.33332 3.79163 7.58332 3.79163H18.4167C21.6667 3.79163 23.8333 5.41663 23.8333 9.20829V16.7916C23.8333 20.5833 21.6667 22.2083 18.4167 22.2083Z" stroke="currentColor" stroke-width="1.2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.4167 9.75L15.0258 12.4583C13.91 13.3467 12.0792 13.3467 10.9633 12.4583L7.58334 9.75" stroke="currentColor" stroke-width="1.2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            clientservices@trading.com
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav flex-row gap-4 mt-3 px-2">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <div class="svg-28">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="currentColor" d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <div class="svg-28">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3Z"/></svg>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <div class="svg-28">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="currentColor" d="M18.205 2.25h3.308l-7.227 8.26l8.502 11.24H16.13l-5.214-6.817L4.95 21.75H1.64l7.73-8.835L1.215 2.25H8.04l4.713 6.231l5.45-6.231Zm-1.161 17.52h1.833L7.045 4.126H5.078L17.044 19.77Z"/></svg>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <div class="svg-28">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77Z"/></svg>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER -->
<div class="copyright">
    <div class="container-lg">
        Copyright © 2023 TradeInSync. All rights reserved.
    </div>
</div>
