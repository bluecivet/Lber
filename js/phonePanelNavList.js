
function phoneNavListStyle()
{

	// navList wrap by navListShow
	let navList = $(".navList");
	navList.wrap('<div class = "navListShow"> </div>');
	let navListShow = $(".navListShow");
	navListShow.hide();		// hide it first when the page load

	// add logo to navlist
	let navLogo = $('<div class = "navListLogo"></div>');
	navLogo.append($('<img src="image/logo.png">'));
	navLogo.append($('<span>Lber</span>'));
	navListShow.prepend(navLogo);

	// add a cover to wrap use to make a back to wrap
	let wrap = $(".wrap");
	let cover = $('<div class = "wrapCover"></div>');
	wrap.prepend(cover);
	cover.hide();

	let navListIcon = $(".navListIcon");
	navListIcon.on("click", function()
	{

		// action navlist slide to left
		navListShow.show();
		navList.show();
		cover.show();
		$("panelOption").show();
		navListIcon.toggleClass("fa-rotate-90");
		wrap.css("position", "relative");
		navListShow.css("left", "90%");
		wrap.css("left", "-70%");
		$("body").css("overflow", "hidden");

	});

	// add when the logo image is click then go to the main page
	navLogo.on("click", function()
	{
		window.location.replace("index.html");
	});


	// when the panel option list is click remove side bar on the phone
	$(".panelOption .navList li").on("click", function()
	{
		cover.click();
	})

	// add listener to wrap so than when click the menu page move to right
	cover.on("click", function()
	{
		navListIcon.toggleClass("fa-rotate-90");

		navListShow.css("left", "100%");
		wrap.css("left", "0%");
		cover.hide();
		let timer = setTimeout(function()
		{
			navList.hide();
			navListShow.hide();
			wrap.css("position", "static");
			$("body").css("overflow", "scroll");
		}, 1000);
		
	});

}


function desktopNavListStyle()
{
	$(".navList").show();
}
