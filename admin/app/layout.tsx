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

            <script type="text/javascript" src="/assets/js/jquery.min.js"/>
            <script type="text/javascript" src="/assets/js/popper.min.js"/>
            <script type="text/javascript" src="/assets/js/bootstrap.min.js"/>
            <script type="text/javascript" src="/assets/js/modernizr.min.js"/>
            <script type="text/javascript" src="/assets/js/detect.js"/>
            <script type="text/javascript" src="/assets/js/jquery.slimscroll.js"/>
            <script type="text/javascript" src="/assets/js/horizontal-menu.js"/>
            <script type="text/javascript" src="/assets/plugins/switchery/switchery.min.js"/>
            <script type="text/javascript" src="/assets/js/core.js"/>
        </head>
        <body>

        <main>{children}</main>
        </body>
        </html>
    )
}