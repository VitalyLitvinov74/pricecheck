export default function RootLayout({children,}: {
    children: React.ReactNode
}) {
    return (
        <html lang="en">
        <head>
            <link href= "/assets/plugins/switchery/switchery.min.css" rel="stylesheet" />
            <link href= "/assets/css/bootstrap.min.css" rel="stylesheet" />
            <link href= "/assets/css/icons.css" rel="stylesheet" />
            <link href= "/assets/css/flag-icon.min.css" rel="stylesheet" />
            <link href= "/assets/css/style.css" rel="stylesheet" />
        </head>
        <body className="horizontal-layout">

        <div id="containerbar" className="container-fluid">
            
            <div className="rightbar">
                
                <div className="topbar-mobile">
                    <div className="row align-items-center">
                        <div className="col-md-12">
                            <div className="mobile-logobar">
                                <a className="mobile-logo">
                                    <img src="/assets/images/logo.svg" className="img-fluid" alt="logo" />
                                </a>
                            </div>
                            <div className="mobile-togglebar">
                                <ul className="list-inline mb-0">
                                    <li className="list-inline-item">
                                        <div className="topbar-toggle-icon">
                                            <a className="topbar-toggle-hamburger" >
                                                <img src="/assets/images/svg-icon/horizontal.svg"
                                                     className="img-fluid menu-hamburger-horizontal" alt="horizontal" />
                                                    <img src="/assets/images/svg-icon/verticle.svg"
                                                         className="img-fluid menu-hamburger-vertical" alt="verticle" />
                                            </a>
                                        </div>
                                    </li>
                                    <li className="list-inline-item">
                                        <div className="menubar">
                                            <a className="menu-hamburger navbar-toggle bg-transparent" data-toggle="collapse"
                                               data-target="#navbar-menu" aria-expanded="true">
                                                <img src="/assets/images/svg-icon/collapse.svg"
                                                     className="img-fluid menu-hamburger-collapse" alt="collapse" />
                                                    <img src="/assets/images/svg-icon/close.svg"
                                                         className="img-fluid menu-hamburger-close" alt="close" />
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div className="topbar">
                    
                    <div className="container-fluid">
                        
                        <div className="row align-items-center">
                            
                            <div className="col-md-12 align-self-center">
                                <div className="togglebar">
                                    <ul className="list-inline mb-0">
                                        <li className="list-inline-item">
                                            <div className="logobar">
                                                <a className="logo logo-large">
                                                    <img src="/assets/images/logo.svg" className="img-fluid" alt="logo" />
                                                </a>
                                            </div>
                                        </li>
                                        <li className="list-inline-item">
                                            <div className="searchbar">
                                                <form>
                                                    <div className="input-group">
                                                        <input type="search" className="form-control"
                                                               placeholder="Search" aria-label="Search"
                                                               aria-describedby="button-addon2" />
                                                            <div className="input-group-append">
                                                                <button className="btn" type="submit"
                                                                        id="button-addon2">
                                                                    <img
                                                                    src="/assets/images/svg-icon/search.svg"
                                                                    className="img-fluid" alt="search" />
                                                                </button>
                                                            </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div className="infobar">
                                    <ul className="list-inline mb-0">
                                        <li className="list-inline-item">
                                            <div className="settingbar">
                                                <a id="infobar-settings-open"
                                                   className="infobar-icon">
                                                    <img src="/assets/images/svg-icon/settings.svg" className="img-fluid"
                                                         alt="settings" />
                                                </a>
                                            </div>
                                        </li>
                                        <li className="list-inline-item">
                                            <div className="notifybar">
                                                <div className="dropdown">
                                                    <a className="dropdown-toggle infobar-icon" href="#" role="button"
                                                       id="notoficationlink" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false"><img
                                                        src="/assets/images/svg-icon/notifications.svg"
                                                        className="img-fluid" alt="notifications" />
                                                        <span className="live-icon" />
                                                    </a>
                                                    <div className="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="notoficationlink">
                                                        <div className="notification-dropdown-title">
                                                            <h4>Notifications</h4>
                                                        </div>
                                                        <ul className="list-unstyled">
                                                            <li className="media dropdown-item">
                                                                <span
                                                                    className="action-icon badge badge-primary-inverse"><i
                                                                    className="feather icon-dollar-sign"></i></span>
                                                                <div className="media-body">
                                                                    <h5 className="action-title">$135 received</h5>
                                                                    <p><span className="timing">Today, 10:45 AM</span>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li className="media dropdown-item">
                                                                <span
                                                                    className="action-icon badge badge-success-inverse"><i
                                                                    className="feather icon-file"></i></span>
                                                                <div className="media-body">
                                                                    <h5 className="action-title">Project X prototype
                                                                        approved</h5>
                                                                    <p><span
                                                                        className="timing">Yesterday, 01:40 PM</span>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li className="media dropdown-item">
                                                                <span
                                                                    className="action-icon badge badge-danger-inverse"><i
                                                                    className="feather icon-eye"></i></span>
                                                                <div className="media-body">
                                                                    <h5 className="action-title">John requested to view
                                                                        wireframe</h5>
                                                                    <p><span
                                                                        className="timing">3 Sep 2019, 05:22 PM</span>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li className="media dropdown-item">
                                                                <span
                                                                    className="action-icon badge badge-warning-inverse"><i
                                                                    className="feather icon-package"></i></span>
                                                                <div className="media-body">
                                                                    <h5 className="action-title">Sports shoes are out of
                                                                        stock</h5>
                                                                    <p><span
                                                                        className="timing">15 Sep 2019, 02:55 PM</span>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li className="list-inline-item">
                                            <div className="languagebar">
                                                <div className="dropdown">
                                                    <a className="dropdown-toggle" href="#" role="button"
                                                       id="languagelink" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false"><i
                                                        className="flag flag-icon-us flag-icon-squared"></i></a>
                                                    <div className="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="languagelink">
                                                        <a className="dropdown-item" href="#"><i
                                                            className="flag flag-icon-us flag-icon-squared"></i>English</a>
                                                        <a className="dropdown-item" href="#"><i
                                                            className="flag flag-icon-de flag-icon-squared"></i>German</a>
                                                        <a className="dropdown-item" href="#"><i
                                                            className="flag flag-icon-bl flag-icon-squared"></i>France</a>
                                                        <a className="dropdown-item" href="#"><i
                                                            className="flag flag-icon-ru flag-icon-squared"></i>Russian</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li className="list-inline-item">
                                            <div className="profilebar">
                                                <div className="dropdown">
                                                    <a className="dropdown-toggle" href="#" role="button"
                                                       id="profilelink" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false"><img src="/assets/images/users/profile.svg"
                                                                                  className="img-fluid"
                                                                                  alt="profile" /><span
                                                        className="feather icon-chevron-down live-icon"></span></a>
                                                    <div className="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="profilelink">
                                                        <div className="dropdown-item">
                                                            <div className="profilename">
                                                                <h5>John Doe</h5>
                                                            </div>
                                                        </div>
                                                        <div className="userbox">
                                                            <ul className="list-unstyled mb-0">
                                                                <li className="media dropdown-item">
                                                                    <a href="#" className="profile-icon"><img
                                                                        src="/assets/images/svg-icon/user.svg"
                                                                        className="img-fluid" alt="user" />My Profile</a>
                                                                </li>
                                                                <li className="media dropdown-item">
                                                                    <a href="#" className="profile-icon"><img
                                                                        src="/assets/images/svg-icon/email.svg"
                                                                        className="img-fluid" alt="email" />Email</a>
                                                                </li>
                                                                <li className="media dropdown-item">
                                                                    <a href="#" className="profile-icon"><img
                                                                        src="/assets/images/svg-icon/logout.svg"
                                                                        className="img-fluid" alt="logout" />Logout</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li className="list-inline-item menubar-toggle">
                                            <div className="menubar">
                                                <a className="menu-hamburger navbar-toggle bg-transparent"
                                                   data-toggle="collapse"
                                                   data-target="#navbar-menu" aria-expanded="true">
                                                    <img src="/assets/images/svg-icon/collapse.svg"
                                                         className="img-fluid menu-hamburger-collapse" alt="collapse" />
                                                        <img src="/assets/images/svg-icon/close.svg"
                                                             className="img-fluid menu-hamburger-close" alt="close" />
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                
                <div className="navigationbar">
                    
                    <div className="container-fluid">
                        
                        <nav className="horizontal-nav mobile-navbar fixed-navbar">
                            <div className="collapse navbar-collapse active" id="navbar-menu">
                                <ul className="horizontal-menu in">
                                    <li className="scroll dropdown">
                                        <a className="dropdown-toggle" data-toggle="dropdown"><img
                                            src="/assets/images/svg-icon/dashboard.svg" className="img-fluid"
                                            alt="dashboard" /><span>Dashboard</span></a>
                                        <ul className="dropdown-menu animated">
                                            <li><a>CRM</a></li>
                                            <li><a>eCommerce</a></li>
                                            <li><a>Hospital</a></li>
                                            <li><a>Crypto</a></li>
                                            <li><a>School</a></li>
                                        </ul>
                                    </li>
                                    <li className="dropdown">
                                        <a  className="dropdown-toggle" data-toggle="dropdown"><img
                                            src="/assets/images/svg-icon/apps.svg" className="img-fluid"
                                            alt="apps" /><span>Apps</span></a>
                                        <ul className="dropdown-menu animated">
                                            <li><a >Calender</a></li>
                                            <li><a >Chat</a></li>
                                            <li className="dropdown">
                                                <a  className="dropdown-toggle"
                                                   data-toggle="dropdown">Email</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a>Inbox</a></li>
                                                    <li><a>Open</a></li>
                                                    <li><a>Compose</a></li>
                                                </ul>
                                            </li>
                                            <li><a>Kanban Board</a></li>
                                            <li><a>Onboarding Screens</a></li>
                                        </ul>
                                    </li>
                                    <li className="dropdown active">
                                        <a className="dropdown-toggle" data-toggle="dropdown"><img
                                            src="/assets/images/svg-icon/components.svg" className="img-fluid"
                                            alt="components" /><span>Components</span></a>
                                        <ul className="dropdown-menu animated in">
                                            <li className="dropdown active">
                                                <a className="dropdown-toggle"
                                                   data-toggle="dropdown"><span>Forms</span></a>
                                                <ul className="dropdown-menu animated in">
                                                    <li className="active"><a className="active">Basic Elements</a></li>
                                                    <li><a>Groups</a></li>
                                                    <li><a>Layouts</a></li>
                                                    <li><a>Color Pickers</a></li>
                                                    <li><a>Date Pickers</a></li>
                                                    <li><a>Editors</a></li>
                                                    <li><a>File Uploads</a></li>
                                                    <li><a>Input Mask</a></li>
                                                    <li><a>MaxLength</a></li>
                                                    <li><a>Selects</a></li>
                                                    <li><a>Touchspin</a></li>
                                                    <li><a>Validations</a></li>
                                                    <li><a>Wizards</a></li>
                                                    <li><a>X-editable</a></li>
                                                </ul>
                                            </li>
                                            <li className="dropdown">
                                                <a className="dropdown-toggle"
                                                   data-toggle="dropdown">Icons</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a>SVG</a></li>
                                                    <li><a>Dripicons</a></li>
                                                    <li><a>Feather</a></li>
                                                    <li><a>Flag</a></li>
                                                    <li><a>Font Awesome</a></li>
                                                    <li><a>Ion</a></li>
                                                    <li><a>Line Awesome</a></li>
                                                    <li><a>Material Design</a></li>
                                                    <li><a>Simple Line</a></li>
                                                    <li><a>Socicon</a></li>
                                                    <li><a>Themify</a></li>
                                                    <li><a>Typicons</a></li>
                                                </ul>
                                            </li>
                                            <li className="dropdown">
                                                <a  className="dropdown-toggle"
                                                   data-toggle="dropdown">Charts</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a>Apex</a></li>
                                                    <li><a>C3</a></li>
                                                    <li><a>Chartist</a></li>
                                                    <li><a>Chartjs</a></li>
                                                    <li><a>Flot</a></li>
                                                    <li><a>Knob</a></li>
                                                    <li><a>Morris</a></li>
                                                    <li><a>Piety</a></li>
                                                    <li><a>Sparkline Chart</a></li>
                                                </ul>
                                            </li>
                                            <li className="dropdown">
                                                <a  className="dropdown-toggle"
                                                   data-toggle="dropdown">Tables</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a >Bootstrap</a></li>
                                                    <li><a >Datatable</a></li>
                                                    <li><a >Editable</a></li>
                                                    <li><a >Foo</a></li>
                                                    <li><a >RWD</a></li>
                                                </ul>
                                            </li>
                                            <li className="dropdown">
                                                <a className="dropdown-toggle"
                                                   data-toggle="dropdown">Maps</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a>Google</a></li>
                                                    <li><a>Vector</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li className="dropdown">
                                        <a className="dropdown-toggle" data-toggle="dropdown"><img
                                            src="/assets/images/svg-icon/pages.svg" className="img-fluid"
                                            alt="pages" /><span>Pages</span></a>
                                        <ul className="dropdown-menu animated">
                                            <li className="dropdown">
                                                <a className="dropdown-toggle"
                                                   data-toggle="dropdown">eCommerce</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a>Product List</a></li>
                                                    <li><a>Product Detail</a></li>
                                                    <li><a>Order List</a></li>
                                                    <li><a>Order Detail</a></li>
                                                    <li><a>Shop</a></li>
                                                    <li><a>Single Product</a></li>
                                                    <li><a>Cart</a></li>
                                                    <li><a>Checkout</a></li>
                                                    <li><a>Thank You</a></li>
                                                    <li><a>My Account</a></li>
                                                </ul>
                                            </li>
                                            <li className="dropdown">
                                                <a className="dropdown-toggle"
                                                   data-toggle="dropdown">Basic</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a >Starter</a></li>
                                                    <li><a >Blog</a></li>
                                                    <li><a >FAQ</a></li>
                                                    <li><a >Gallery</a></li>
                                                    <li><a >Invoice</a></li>
                                                    <li><a >Pricing</a></li>
                                                    <li><a >Timeline</a></li>
                                                </ul>
                                            </li>
                                            <li className="dropdown">
                                                <a  className="dropdown-toggle"
                                                   data-toggle="dropdown">User</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a >Login</a></li>
                                                    <li><a >Register</a></li>
                                                    <li><a >Forgot Password</a></li>
                                                    <li><a >Lock Screen</a></li>
                                                </ul>
                                            </li>
                                            <li className="dropdown">
                                                <a  className="dropdown-toggle"
                                                   data-toggle="dropdown">Error</a>
                                                <ul className="dropdown-menu animated">
                                                    <li><a >Coming Soon</a></li>
                                                    <li><a >Maintenance</a></li>
                                                    <li><a >Error 404</a></li>
                                                    <li><a >Error 500</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li className="scroll"><a><img
                                        src="/assets/images/svg-icon/widgets.svg" className="img-fluid"
                                        alt="widgets" /><span>Widgets</span></a></li>
                                    <li className="dropdown menu-item-has-mega-menu">
                                        <a className="dropdown-toggle" data-toggle="dropdown"><img
                                            src="/assets/images/svg-icon/basic.svg" className="img-fluid"
                                            alt="basic" /><span>Basic UI</span></a>
                                        <div className="mega-menu dropdown-menu animated">
                                            <ul className="mega-menu-row" role="menu">
                                                <li className="mega-menu-col col-md-3">
                                                    <ul className="sub-menu">
                                                        <li><a >Alerts</a></li>
                                                        <li><a >Badges</a></li>
                                                        <li><a >Buttons</a></li>
                                                        <li><a >Cards</a></li>
                                                        <li><a >Carousel</a></li>
                                                    </ul>
                                                </li>
                                                <li className="mega-menu-col col-md-3">
                                                    <ul className="sub-menu">
                                                        <li><a>Collapse</a></li>
                                                        <li><a>Dropdowns</a></li>
                                                        <li><a>Embeds</a></li>
                                                        <li><a>Grids</a></li>
                                                        <li><a>Images</a></li>
                                                    </ul>
                                                </li>
                                                <li className="mega-menu-col col-md-3">
                                                    <ul className="sub-menu">
                                                        <li><a >Media</a></li>
                                                        <li><a >Modals</a></li>
                                                        <li><a >Paginations</a>
                                                        </li>
                                                        <li><a >Popovers</a></li>
                                                        <li><a >Progress Bars</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li className="mega-menu-col col-md-3">
                                                    <ul className="sub-menu">
                                                        <li><a >Spinners</a></li>
                                                        <li><a >Tabs</a></li>
                                                        <li><a >Toasts</a></li>
                                                        <li><a >Tooltips</a></li>
                                                        <li><a >Typography</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li className="dropdown">
                                        <a  className="dropdown-toggle" data-toggle="dropdown"><img
                                            src="/assets/images/svg-icon/advanced.svg" className="img-fluid"
                                            alt="advanced" /><span>Advanced UI</span></a>
                                        <ul className="dropdown-menu animated">
                                            <li><a >Image Crop</a></li>
                                            <li><a >jQuery Confirm</a></li>
                                            <li><a >Nestable</a></li>
                                            <li><a >Pnotify</a></li>
                                            <li><a >Range Slider</a></li>
                                            <li><a >Ratings</a></li>
                                            <li><a >Session Timeout</a></li>
                                            <li><a >Sweet Alerts</a></li>
                                            <li><a >Switchery</a></li>
                                            <li><a >Toolbar</a></li>
                                            <li><a >Tour</a></li>
                                            <li><a >Tree View</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div className="breadcrumbbar">
                    <div className="row align-items-center">
                        <div className="col-md-8 col-lg-8">
                            <h4 className="page-title">Basic Elements</h4>
                            <div className="breadcrumb-list">
                                <ol className="breadcrumb">
                                    <li className="breadcrumb-item"><a >Home</a></li>
                                    <li className="breadcrumb-item"><a href="#">Forms</a></li>
                                    <li className="breadcrumb-item active" aria-current="page">Basic Elements</li>
                                </ol>
                            </div>
                        </div>
                        <div className="col-md-4 col-lg-4">
                            <div className="widgetbar">
                                <button className="btn btn-primary-rgba"><i className="feather icon-plus mr-2"></i>Actions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="contentbar">
                    {children}
                </div>
                <div className="footerbar">
                    <footer className="footer">
                        <p className="mb-0">© 2020 Orbiter - All Rights Reserved.</p>
                    </footer>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="/assets/js/jquery.min.js"/>
        <script type="text/javascript" src="/assets/js/popper.min.js"/>
        <script type="text/javascript" src="/assets/js/bootstrap.min.js"/>
        <script type="text/javascript" src="/assets/js/modernizr.min.js"/>
        <script type="text/javascript" src="/assets/js/detect.js"/>
        <script type="text/javascript" src="/assets/js/jquery.slimscroll.js"/>
        <script type="text/javascript" src="/assets/js/horizontal-menu.js"/>
        <script type="text/javascript" src="/assets/plugins/switchery/switchery.min.js"/>
        <script type="text/javascript" src="/assets/js/core.js"/>
        </body>
        </html>
    )
}