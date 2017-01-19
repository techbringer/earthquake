<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="$ContentLocale" dir="$i18nScriptDirection" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="$ContentLocale" dir="$i18nScriptDirection" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="$ContentLocale" dir="$i18nScriptDirection" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="$ContentLocale" dir="$i18nScriptDirection" class="no-js"> <!--<![endif]-->
	<head>
		<% base_tag %>
		$MetaTags(true)
		<% include OG %>
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">

		$getCSS

		<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

		<% include GA %>
	</head>
	<body class="page-$URLSegment<% if $isMobile %> mobile<% end_if %> page-type-$BodyClass.LowerCase<% if $Menu(2) %> has-secondary-menu<% end_if %>">
		<% include Header %>

		<main id="main">
            <% include SecondaryMenu %>
            <h1 id="page-title" class="title container padding">$Title</h1>
            <% include ContentTop %>
			$Layout
            <% include ContentBottom %>
		</main>
		<% include Footer %>
	</body>
</html>
