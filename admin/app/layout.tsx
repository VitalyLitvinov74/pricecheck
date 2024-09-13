import {Metadata} from "next";
import Link from "next/link";
import {createContext, useState} from "react";
import Breadcrumbs from "./product/properties/button-component";
import NestedClientPage from "./nested-client-page";

export const metadata: Metadata = {
    title: '',
    description: '',
};
export default function RootLayout({children,}: {
    children: React.ReactNode
}) {
    return (
        <html lang="ru">
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
                                    <li className="dropdown">
                                        <a href="" className="dropdown-toggle" data-toggle="dropdown"><img
                                            src="/assets/images/svg-icon/basic.svg" className="img-fluid"
                                            alt="apps"/><span>Товары</span></a>
                                        <ul className="dropdown-menu animated">
                                            <li><Link href="/product">Список товаров</Link></li>
                                            <li><Link href="/product/properties">Свойства</Link></li>
                                            <li><Link href="/product/properties">Импорт</Link></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <NestedClientPage>
                    {children}
                </NestedClientPage>


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
        {/*<script type="text/javascript" src="/assets/plugins/switchery/switchery.min.js"/>*/}
        <script type="text/javascript" src="/assets/js/core.js"/>
        </body>
        </html>
    )
}