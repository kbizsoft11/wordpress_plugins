var gettextcolor = "#"+jQuery(".hidtex_color").val();
var getbackcolor = "#"+jQuery(".hid_back_color").val();
var getacchcolor = "#"+jQuery(".hid_acolor").val();

// console.log(gettextcolor);
// console.log(getbackcolor);
// console.log(getacchcolor);

jQuery("body:not(.gutenberg-editor-page)").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});


jQuery("body table").css({
	'background-color':getbackcolor,
	'color':'#bbc8d4'
});

jQuery("#wpbody a  ").css({
	'color':getacchcolor+'!important'
});

jQuery("#wpbody-content a").css({
	'color':getacchcolor+'!important'
});

jQuery("#wpbody option").css({
	'color':getacchcolor
});

jQuery("body #wpbody a").css({
	'color':getacchcolor
});


jQuery("body table tr").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});

jQuery("body table tr td").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});

jQuery("body input, body select, body button,textarea").css({
	'background-color':getbackcolor,
	'border-color':'#191f25',
	'color':gettextcolor
});

jQuery("body label, p").css({
	'color':gettextcolor
});

jQuery("body .wrap div").css({
	'background-color':getbackcolor+'!important',
	'background':'#32373c !important',
	'border-color':'#191f25 !important',
	'color':gettextcolor+' !important'
});

jQuery("body .card").css({
	'background-color':getbackcolor+'!important',
	'background':getbackcolor+'#32373c !important',
	'border-color':'#191f25 !important',
	'color':gettextcolor+'!important'
});

jQuery("body:not(.gutenberg-editor-page) .button, body:not(.gutenberg-editor-page) .button-secondary, body:not(.gutenberg-editor-page).wp-core-ui .button, body:not(.gutenberg-editor-page).wp-core-ui .button-secondary").css({
	'background':getbackcolor,
	'border-color':'#32373c',
	'box-shadow':'0 1px 0 #191f25',
	'color':gettextcolor
});

jQuery("body div h1,h2,h3,h4,h5,h6").css({
	'color':gettextcolor
});

jQuery("body p").css({
	
	'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page) #wpbody, body:not(.gutenberg-editor-page) #wpfooter").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody,body:not(.gutenberg-editor-page) #wpfooter, body:not(.gutenberg-editor-page) #wpbody p,body:not(.gutenberg-editor-page) #wpbody code,body:not(.gutenberg-editor-page) #wpbody kbd,body:not(.gutenberg-editor-page) #wpbody label,body:not(.gutenberg-editor-page) #wpbody .form-table th,body:not(.gutenberg-editor-page) #wpbody .form-wrap label,body:not(.gutenberg-editor-page) #wpbody .form-wrap p,body:not(.gutenberg-editor-page) #wpbody p.description,body:not(.gutenberg-editor-page) #wpbody .importer-title,body:not(.gutenberg-editor-page) #wpbody .menu-in-location,body:not(.gutenberg-editor-page) #wpbody .theme-location-set,body:not(.gutenberg-editor-page) #wpfooter p,body:not(.gutenberg-editor-page) #wpfooter code,body:not(.gutenberg-editor-page) #wpfooter kbd,body:not(.gutenberg-editor-page) #wpfooter label,body:not(.gutenberg-editor-page) #wpfooter .form-table th,body:not(.gutenberg-editor-page) #wpfooter .form-wrap label,body:not(.gutenberg-editor-page) #wpfooter .form-wrap p,body:not(.gutenberg-editor-page) #wpfooter p.description,body:not(.gutenberg-editor-page) #wpfooter .importer-title,body:not(.gutenberg-editor-page) #wpfooter .menu-in-location,body:not(.gutenberg-editor-page) #wpfooter .theme-location-set, body:not(.gutenberg-editor-page) #wpbody #wpadminbar *,body:not(.gutenberg-editor-page) #wpfooter #wpadminbar *,body:not(.gutenberg-editor-page) #wpbody table,body:not(.gutenberg-editor-page) #wpfooter table, body:not(.gutenberg-editor-page) #wpbody table p,body:not(.gutenberg-editor-page) #wpfooter table p,body:not(.gutenberg-editor-page) #wpbody table tr,body:not(.gutenberg-editor-page) #wpfooter table tr").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #templateside>ul li a,body:not(.gutenberg-editor-page) #wpbody #templateside>ul li span,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li a,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li span, body:not(.gutenberg-editor-page) #wpbody #templateside>ul li a.hover,body:not(.gutenberg-editor-page) #wpbody #templateside>ul li a:hover,body:not(.gutenberg-editor-page) #wpbody #templateside>ul li span.hover,body:not(.gutenberg-editor-page) #wpbody #templateside>ul li span:hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li a.hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li a:hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li span.hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li span:hover").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.widefat,body:not(.gutenberg-editor-page) #wpfooter table.widefat").css({
	'border-color':'#32373c'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.widefat thead th,body:not(.gutenberg-editor-page) #wpbody table.widefat thead td,body:not(.gutenberg-editor-page) #wpbody table.widefat tfoot th,body:not(.gutenberg-editor-page) #wpbody table.widefat tfoot td,body:not(.gutenberg-editor-page) #wpfooter table.widefat thead th,body:not(.gutenberg-editor-page) #wpfooter table.widefat thead td,body:not(.gutenberg-editor-page) #wpfooter table.widefat tfoot th,body:not(.gutenberg-editor-page) #wpfooter table.widefat tfoot td, body:not(.gutenberg-editor-page) #wpbody table.widefat p,body:not(.gutenberg-editor-page) #wpfooter table.widefat p, body:not(.gutenberg-editor-page) #wpbody table.striped tbody tr,body:not(.gutenberg-editor-page) #wpfooter table.striped tbody tr").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.striped tbody tr:nth-child(odd),body:not(.gutenberg-editor-page) #wpfooter table.striped tbody tr:nth-child(odd)").css({
	'background-color':getbackcolor
});




jQuery("body:not(.gutenberg-editor-page) #wpbody table.plugins .active td,body:not(.gutenberg-editor-page) #wpbody table.plugins .active th,body:not(.gutenberg-editor-page) #wpfooter table.plugins .active td,body:not(.gutenberg-editor-page) #wpfooter table.plugins .active th").css({
	'background-color':getbackcolor
	
});



jQuery("body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active+tr.inactive td,body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active+tr.inactive th,body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active.plugin-update-tr+tr.inactive td,body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active.plugin-update-tr+tr.inactive th,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active+tr.inactive td,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active+tr.inactive th,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active.plugin-update-tr+tr.inactive td,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active.plugin-update-tr+tr.inactive th").css({
	'background-color':getbackcolor
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr, body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr th,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr td,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr th,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr td").css({
	'background-color':getbackcolor
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr th *::before,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr th *::after,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr td *::before,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr td *::after,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr th *::before,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr th *::after,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr td *::before,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr td *::after").css({
	'background-color':getbackcolor
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody table.updates-table tr,body:not(.gutenberg-editor-page) #wpfooter table.updates-table tr, body:not(.gutenberg-editor-page) #wpbody .tablenav p,body:not(.gutenberg-editor-page) #wpbody .tablenav span,body:not(.gutenberg-editor-page) #wpfooter .tablenav p,body:not(.gutenberg-editor-page) #wpfooter .tablenav span").css({
	'background-color':getbackcolor
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody .subsubsub,body:not(.gutenberg-editor-page) #wpbody .subsubsub li,body:not(.gutenberg-editor-page) #wpfooter .subsubsub,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li").css({
	'background-color':getbackcolor
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody .subsubsub a span.count,body:not(.gutenberg-editor-page) #wpbody .subsubsub a.current span.count,body:not(.gutenberg-editor-page) #wpbody .subsubsub li a span.count,body:not(.gutenberg-editor-page) #wpbody .subsubsub li a.current span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub a span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub a.current span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li a span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li a.current span.count").css({
	'color':gettextcolor
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody .subsubsub a.current,body:not(.gutenberg-editor-page) #wpbody .subsubsub li a.current,body:not(.gutenberg-editor-page) #wpfooter .subsubsub a.current,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li a.current, body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages-navspan,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages-navspan").css({
	'background-color':getbackcolor
	
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages a,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages a").css({
	'background':getbackcolor,
	'border-color':'#191f25',
	'color':gettextcolor
	
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages a span,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages a span").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody, body:not(.gutenberg-editor-page) #wpfooter").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages a:hover,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages a:hover").css({
	'background':'#00a0d2',
	'border-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .notice,body:not(.gutenberg-editor-page) #wpbody .error,body:not(.gutenberg-editor-page) #wpbody .updated,body:not(.gutenberg-editor-page) #wpbody .update-nag,body:not(.gutenberg-editor-page) #wpfooter .notice,body:not(.gutenberg-editor-page) #wpfooter .error,body:not(.gutenberg-editor-page) #wpfooter .updated,body:not(.gutenberg-editor-page) #wpfooter .update-nag").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .notice p,body:not(.gutenberg-editor-page) #wpbody .updated p,body:not(.gutenberg-editor-page) #wpbody .fileedit-sub,body:not(.gutenberg-editor-page) #wpbody .about-wrap h1,body:not(.gutenberg-editor-page) #wpbody .about-wrap .about-text,body:not(.gutenberg-editor-page) #wpbody #bulk-titles div a:before,body:not(.gutenberg-editor-page) #wpbody .notice-dismiss:before,body:not(.gutenberg-editor-page) #wpbody .tagchecklist .ntdelbutton .remove-tag-icon:before,body:not(.gutenberg-editor-page) #wpbody .welcome-panel .welcome-panel-close:before,body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel .try-gutenberg-panel-close:before,body:not(.gutenberg-editor-page) #wpbody .pressthis-js-toggle .dashicons,body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel p,body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel-column p.about-description,body:not(.gutenberg-editor-page) #wpbody .howto,body:not(.gutenberg-editor-page) #wpbody .item-type,body:not(.gutenberg-editor-page) #wpbody .is-submenu,body:not(.gutenberg-editor-page) #wpbody .nonessential,body:not(.gutenberg-editor-page) #wpbody #future-posts ul span,body:not(.gutenberg-editor-page) #wpbody #published-posts ul span,body:not(.gutenberg-editor-page) #wpbody #dashboard-widgets h3,body:not(.gutenberg-editor-page) #wpbody #dashboard-widgets h4,body:not(.gutenberg-editor-page) #wpbody #dashboard_quick_press .drafts h2,body:not(.gutenberg-editor-page) #wpbody #dashboard_right_now li a:before,body:not(.gutenberg-editor-page) #wpbody #dashboard_right_now li span:before,body:not(.gutenberg-editor-page) #wpbody .welcome-panel .welcome-icon:before,body:not(.gutenberg-editor-page) #wpbody .community-events li,body:not(.gutenberg-editor-page) #wpbody #dashboard_activity .subsubsub a .count,body:not(.gutenberg-editor-page) #wpbody #dashboard_activity .subsubsub a.current .count,body:not(.gutenberg-editor-page) #wpbody #latest-comments #the-comment-list .comment-meta,body:not(.gutenberg-editor-page) #wpbody #dashboard_quick_press .drafts li time,body:not(.gutenberg-editor-page) #wpbody #title-wrap #title-prompt-text,body:not(.gutenberg-editor-page) #wpbody .textarea-wrap #content-prompt-text,body:not(.gutenberg-editor-page) #wpbody #post-body ul.add-menu-item-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpbody #post-body ul.category-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpbody #side-sortables .add-menu-item-tabs .tabs a,body:not(.gutenberg-editor-page) #wpbody #side-sortables .category-tabs .tabs a,body:not(.gutenberg-editor-page) #wpbody .wp-tab-bar .wp-tab-active a,body:not(.gutenberg-editor-page) #wpbody .link-to-original,body:not(.gutenberg-editor-page) #wpbody .accordion-section-title:after,body:not(.gutenberg-editor-page) #wpbody .handlediv,body:not(.gutenberg-editor-page) #wpbody .item-edit,body:not(.gutenberg-editor-page) #wpbody .postbox .handlediv.button-link,body:not(.gutenberg-editor-page) #wpbody .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpbody .edit-comment-author,body:not(.gutenberg-editor-page) #wpbody #comment-link-box,body:not(.gutenberg-editor-page) #wpbody #edit-slug-box,body:not(.gutenberg-editor-page) #wpbody .inactive-sidebar .description,body:not(.gutenberg-editor-page) #wpbody .widget-holder .description,body:not(.gutenberg-editor-page) #wpbody #available-widgets .widget-description,body:not(.gutenberg-editor-page) #wpbody #widgets-right a.widget-control-edit,body:not(.gutenberg-editor-page) #wpbody .in-widget-title,body:not(.gutenberg-editor-page) #wpbody .edit-attachment-frame .attachment-info .filename,body:not(.gutenberg-editor-page) #wpbody .attachment-details .setting span,body:not(.gutenberg-editor-page) #wpbody .compat-item label span,body:not(.gutenberg-editor-page) #wpbody .media-sidebar .setting span,body:not(.gutenberg-editor-page) #wpbody .upload-plugin .install-help,body:not(.gutenberg-editor-page) #wpbody .upload-theme .install-help,body:not(.gutenberg-editor-page) #wpbody .subtitle,body:not(.gutenberg-editor-page) #wpfooter .notice p,body:not(.gutenberg-editor-page) #wpfooter .updated p,body:not(.gutenberg-editor-page) #wpfooter .fileedit-sub,body:not(.gutenberg-editor-page) #wpfooter .about-wrap h1,body:not(.gutenberg-editor-page) #wpfooter .about-wrap .about-text,body:not(.gutenberg-editor-page) #wpfooter #bulk-titles div a:before,body:not(.gutenberg-editor-page) #wpfooter .notice-dismiss:before,body:not(.gutenberg-editor-page) #wpfooter .tagchecklist .ntdelbutton .remove-tag-icon:before,body:not(.gutenberg-editor-page) #wpfooter .welcome-panel .welcome-panel-close:before,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel .try-gutenberg-panel-close:before,body:not(.gutenberg-editor-page) #wpfooter .pressthis-js-toggle .dashicons,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel p,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel-column p.about-description,body:not(.gutenberg-editor-page) #wpfooter .howto,body:not(.gutenberg-editor-page) #wpfooter .item-type,body:not(.gutenberg-editor-page) #wpfooter .is-submenu,body:not(.gutenberg-editor-page) #wpfooter .nonessential,body:not(.gutenberg-editor-page) #wpfooter #future-posts ul span,body:not(.gutenberg-editor-page) #wpfooter #published-posts ul span,body:not(.gutenberg-editor-page) #wpfooter #dashboard-widgets h3,body:not(.gutenberg-editor-page) #wpfooter #dashboard-widgets h4,body:not(.gutenberg-editor-page) #wpfooter #dashboard_quick_press .drafts h2,body:not(.gutenberg-editor-page) #wpfooter #dashboard_right_now li a:before,body:not(.gutenberg-editor-page) #wpfooter #dashboard_right_now li span:before,body:not(.gutenberg-editor-page) #wpfooter .welcome-panel .welcome-icon:before,body:not(.gutenberg-editor-page) #wpfooter .community-events li,body:not(.gutenberg-editor-page) #wpfooter #dashboard_activity .subsubsub a .count,body:not(.gutenberg-editor-page) #wpfooter #dashboard_activity .subsubsub a.current .count,body:not(.gutenberg-editor-page) #wpfooter #latest-comments #the-comment-list .comment-meta,body:not(.gutenberg-editor-page) #wpfooter #dashboard_quick_press .drafts li time,body:not(.gutenberg-editor-page) #wpfooter #title-wrap #title-prompt-text,body:not(.gutenberg-editor-page) #wpfooter .textarea-wrap #content-prompt-text,body:not(.gutenberg-editor-page) #wpfooter #post-body ul.add-menu-item-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpfooter #post-body ul.category-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpfooter #side-sortables .add-menu-item-tabs .tabs a,body:not(.gutenberg-editor-page) #wpfooter #side-sortables .category-tabs .tabs a,body:not(.gutenberg-editor-page) #wpfooter .wp-tab-bar .wp-tab-active a,body:not(.gutenberg-editor-page) #wpfooter .link-to-original,body:not(.gutenberg-editor-page) #wpfooter .accordion-section-title:after,body:not(.gutenberg-editor-page) #wpfooter .handlediv,body:not(.gutenberg-editor-page) #wpfooter .item-edit,body:not(.gutenberg-editor-page) #wpfooter .postbox .handlediv.button-link,body:not(.gutenberg-editor-page) #wpfooter .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpfooter .edit-comment-author,body:not(.gutenberg-editor-page) #wpfooter #comment-link-box,body:not(.gutenberg-editor-page) #wpfooter #edit-slug-box,body:not(.gutenberg-editor-page) #wpfooter .inactive-sidebar .description,body:not(.gutenberg-editor-page) #wpfooter .widget-holder .description,body:not(.gutenberg-editor-page) #wpfooter #available-widgets .widget-description,body:not(.gutenberg-editor-page) #wpfooter #widgets-right a.widget-control-edit,body:not(.gutenberg-editor-page) #wpfooter .in-widget-title,body:not(.gutenberg-editor-page) #wpfooter .edit-attachment-frame .attachment-info .filename,body:not(.gutenberg-editor-page) #wpfooter .attachment-details .setting span,body:not(.gutenberg-editor-page) #wpfooter .compat-item label span,body:not(.gutenberg-editor-page) #wpfooter .media-sidebar .setting span,body:not(.gutenberg-editor-page) #wpfooter .upload-plugin .install-help,body:not(.gutenberg-editor-page) #wpfooter .upload-theme .install-help,body:not(.gutenberg-editor-page) #wpfooter .subtitle").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .spinner,body:not(.gutenberg-editor-page) #wpfooter .spinner").css({
	'background-color':getbackcolor,
	'border':'1px solid #fff',
	'border-radius':'100%'
	
});

// jQuery("body:not(.gutenberg-editor-page) #wpbody code,body:not(.gutenberg-editor-page) #wpbody kbd,body:not(.gutenberg-editor-page) #wpfooter code,body:not(.gutenberg-editor-page) #wpfooter kbd, body:not(.gutenberg-editor-page) #wpbody ul#adminmenu a.wp-has-current-submenu:after,body:not(.gutenberg-editor-page) #wpbody ul#adminmenu>li.current>a.current:after,body:not(.gutenberg-editor-page) #wpfooter ul#adminmenu a.wp-has-current-submenu:after,body:not(.gutenberg-editor-page) #wpfooter ul#adminmenu>li.current>a.current:after").css({
// 	'border-right-color':'#23282d'
	
// });


jQuery("body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .comment,body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .pingback,body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .comment,body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .pingback, body:not(.gutenberg-editor-page) #wpbody #templateside>ul,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul").css({
	'background-color':getbackcolor,
	'border-color':'#32373c',
	'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page)").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page) #wpbody, body:not(.gutenberg-editor-page) #wpfooter").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page) #wpbody p,body:not(.gutenberg-editor-page) #wpbody code,body:not(.gutenberg-editor-page) #wpbody kbd,body:not(.gutenberg-editor-page) #wpbody label,body:not(.gutenberg-editor-page) #wpbody .form-table th,body:not(.gutenberg-editor-page) #wpbody .form-wrap label,body:not(.gutenberg-editor-page) #wpbody .form-wrap p,body:not(.gutenberg-editor-page) #wpbody p.description,body:not(.gutenberg-editor-page) #wpbody .importer-title,body:not(.gutenberg-editor-page) #wpbody .menu-in-location,body:not(.gutenberg-editor-page) #wpbody .theme-location-set,body:not(.gutenberg-editor-page) #wpfooter p,body:not(.gutenberg-editor-page) #wpfooter code,body:not(.gutenberg-editor-page) #wpfooter kbd,body:not(.gutenberg-editor-page) #wpfooter label,body:not(.gutenberg-editor-page) #wpfooter .form-table th,body:not(.gutenberg-editor-page) #wpfooter .form-wrap label,body:not(.gutenberg-editor-page) #wpfooter .form-wrap p,body:not(.gutenberg-editor-page) #wpfooter p.description,body:not(.gutenberg-editor-page) #wpfooter .importer-title,body:not(.gutenberg-editor-page) #wpfooter .menu-in-location,body:not(.gutenberg-editor-page) #wpfooter .theme-location-set").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #wpadminbar *,body:not(.gutenberg-editor-page) #wpfooter #wpadminbar *").css({
	'color':'inherit !important'
	
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table,body:not(.gutenberg-editor-page) #wpfooter table").css({
	'background-color':getbackcolor,
	'border-color':'#32373c'
	
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table p,body:not(.gutenberg-editor-page) #wpfooter table p").css({
	'color':gettextcolor
	
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table tr,body:not(.gutenberg-editor-page) #wpfooter table tr, body:not(.gutenberg-editor-page) #wpbody table tr th,body:not(.gutenberg-editor-page) #wpbody table tr td,body:not(.gutenberg-editor-page) #wpfooter table tr th,body:not(.gutenberg-editor-page) #wpfooter table tr td").css({
	'background-color':'transparent',
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.widefat,body:not(.gutenberg-editor-page) #wpfooter table.widefat").css({
	'border-color':'#32373c'

});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.widefat thead th,body:not(.gutenberg-editor-page) #wpbody table.widefat thead td,body:not(.gutenberg-editor-page) #wpbody table.widefat tfoot th,body:not(.gutenberg-editor-page) #wpbody table.widefat tfoot td,body:not(.gutenberg-editor-page) #wpfooter table.widefat thead th,body:not(.gutenberg-editor-page) #wpfooter table.widefat thead td,body:not(.gutenbuttonberg-editor-page) #wpfooter table.widefat tfoot th,body:not(.gutenberg-editor-page) #wpfooter table.widefat tfoot td").css({
	'border-top-color':'#191f25',
	'border-bottom-color':'#23282d',
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.widefat p,body:not(.gutenberg-editor-page) #wpfooter table.widefat p").css({
	
	'color':gettextcolor
	
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.striped tbody tr,body:not(.gutenberg-editor-page) #wpfooter table.striped tbody tr").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.striped tbody tr:nth-child(odd),body:not(.gutenberg-editor-page) #wpfooter table.striped tbody tr:nth-child(odd)").css({
	'background-color':getbackcolor
	
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.plugins .active td,body:not(.gutenberg-editor-page) #wpbody table.plugins .active th,body:not(.gutenberg-editor-page) #wpfooter table.plugins .active td,body:not(.gutenberg-editor-page) #wpfooter table.plugins .active th").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active+tr.inactive td,body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active+tr.inactive th,body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active.plugin-update-tr+tr.inactive td,body:not(.gutenberg-editor-page) #wpbody table.plugins tr.active.plugin-update-tr+tr.inactive th,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active+tr.inactive td,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active+tr.inactive th,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active.plugin-update-tr+tr.inactive td,body:not(.gutenberg-editor-page) #wpfooter table.plugins tr.active.plugin-update-tr+tr.inactive th").css({
	'box-shadow':'inset 0 1px 0 rgba(0,0,0,0.02),inset 0 -1px 0 #23282d'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr th,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr td,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr th,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr td").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr th *::before,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr th *::after,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr td *::before,body:not(.gutenberg-editor-page) #wpbody table.wp-list-table tr td *::after,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr th *::before,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr th *::after,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr td *::before,body:not(.gutenberg-editor-page) #wpfooter table.wp-list-table tr td *::after").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody table.updates-table tr,body:not(.gutenberg-editor-page) #wpfooter table.updates-table tr").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .subsubsub a,body:not(.gutenberg-editor-page) #wpbody .subsubsub li a,body:not(.gutenberg-editor-page) #wpfooter .subsubsub a,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li a").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .subsubsub a span.count,body:not(.gutenberg-editor-page) #wpbody .subsubsub a.current span.count,body:not(.gutenberg-editor-page) #wpbody .subsubsub li a span.count,body:not(.gutenberg-editor-page) #wpbody .subsubsub li a.current span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub a span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub a.current span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li a span.count,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li a.current span.count").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .subsubsub a.current,body:not(.gutenberg-editor-page) #wpbody .subsubsub li a.current,body:not(.gutenberg-editor-page) #wpfooter .subsubsub a.current,body:not(.gutenberg-editor-page) #wpfooter .subsubsub li a.current").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages-navspan,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages-navspan, body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages a,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages a").css({
	'background':getbackcolor,
	'border':'1px solid #23282d'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages a span,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages a span, body:not(.gutenberg-editor-page) #wpbody .tablenav .tablenav-pages a:hover,body:not(.gutenberg-editor-page) #wpfooter .tablenav .tablenav-pages a:hover").css({
	'background':getbackcolor,
	'border-color':'#23282d'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .notice,body:not(.gutenberg-editor-page) #wpbody .error,body:not(.gutenberg-editor-page) #wpbody .updated,body:not(.gutenberg-editor-page) #wpbody .update-nag,body:not(.gutenberg-editor-page) #wpfooter .notice,body:not(.gutenberg-editor-page) #wpfooter .error,body:not(.gutenberg-editor-page) #wpfooter .updated,body:not(.gutenberg-editor-page) #wpfooter .update-nag").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .notice p,body:not(.gutenberg-editor-page) #wpbody .updated p,body:not(.gutenberg-editor-page) #wpbody .fileedit-sub,body:not(.gutenberg-editor-page) #wpbody .about-wrap h1,body:not(.gutenberg-editor-page) #wpbody .about-wrap .about-text,body:not(.gutenberg-editor-page) #wpbody #bulk-titles div a:before,body:not(.gutenberg-editor-page) #wpbody .notice-dismiss:before,body:not(.gutenberg-editor-page) #wpbody .tagchecklist .ntdelbutton .remove-tag-icon:before,body:not(.gutenberg-editor-page) #wpbody .welcome-panel .welcome-panel-close:before,body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel .try-gutenberg-panel-close:before,body:not(.gutenberg-editor-page) #wpbody .pressthis-js-toggle .dashicons,body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel p,body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel-column p.about-description,body:not(.gutenberg-editor-page) #wpbody .howto,body:not(.gutenberg-editor-page) #wpbody .item-type,body:not(.gutenberg-editor-page) #wpbody .is-submenu,body:not(.gutenberg-editor-page) #wpbody .nonessential,body:not(.gutenberg-editor-page) #wpbody #future-posts ul span,body:not(.gutenberg-editor-page) #wpbody #published-posts ul span,body:not(.gutenberg-editor-page) #wpbody #dashboard-widgets h3,body:not(.gutenberg-editor-page) #wpbody #dashboard-widgets h4,body:not(.gutenberg-editor-page) #wpbody #dashboard_quick_press .drafts h2,body:not(.gutenberg-editor-page) #wpbody #dashboard_right_now li a:before,body:not(.gutenberg-editor-page) #wpbody #dashboard_right_now li span:before,body:not(.gutenberg-editor-page) #wpbody .welcome-panel .welcome-icon:before,body:not(.gutenberg-editor-page) #wpbody .community-events li,body:not(.gutenberg-editor-page) #wpbody #dashboard_activity .subsubsub a .count,body:not(.gutenberg-editor-page) #wpbody #dashboard_activity .subsubsub a.current .count,body:not(.gutenberg-editor-page) #wpbody #latest-comments #the-comment-list .comment-meta,body:not(.gutenberg-editor-page) #wpbody #dashboard_quick_press .drafts li time,body:not(.gutenberg-editor-page) #wpbody #title-wrap #title-prompt-text,body:not(.gutenberg-editor-page) #wpbody .textarea-wrap #content-prompt-text,body:not(.gutenberg-editor-page) #wpbody #post-body ul.add-menu-item-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpbody #post-body ul.category-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpbody #side-sortables .add-menu-item-tabs .tabs a,body:not(.gutenberg-editor-page) #wpbody #side-sortables .category-tabs .tabs a,body:not(.gutenberg-editor-page) #wpbody .wp-tab-bar .wp-tab-active a,body:not(.gutenberg-editor-page) #wpbody .link-to-original,body:not(.gutenberg-editor-page) #wpbody .accordion-section-title:after,body:not(.gutenberg-editor-page) #wpbody .handlediv,body:not(.gutenberg-editor-page) #wpbody .item-edit,body:not(.gutenberg-editor-page) #wpbody .postbox .handlediv.button-link,body:not(.gutenberg-editor-page) #wpbody .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpbody .edit-comment-author,body:not(.gutenberg-editor-page) #wpbody #comment-link-box,body:not(.gutenberg-editor-page) #wpbody #edit-slug-box,body:not(.gutenberg-editor-page) #wpbody .inactive-sidebar .description,body:not(.gutenberg-editor-page) #wpbody .widget-holder .description,body:not(.gutenberg-editor-page) #wpbody #available-widgets .widget-description,body:not(.gutenberg-editor-page) #wpbody #widgets-right a.widget-control-edit,body:not(.gutenberg-editor-page) #wpbody .in-widget-title,body:not(.gutenberg-editor-page) #wpbody .edit-attachment-frame .attachment-info .filename,body:not(.gutenberg-editor-page) #wpbody .attachment-details .setting span,body:not(.gutenberg-editor-page) #wpbody .compat-item label span,body:not(.gutenberg-editor-page) #wpbody .media-sidebar .setting span,body:not(.gutenberg-editor-page) #wpbody .upload-plugin .install-help,body:not(.gutenberg-editor-page) #wpbody .upload-theme .install-help,body:not(.gutenberg-editor-page) #wpbody .subtitle,body:not(.gutenberg-editor-page) #wpfooter .notice p,body:not(.gutenberg-editor-page) #wpfooter .updated p,body:not(.gutenberg-editor-page) #wpfooter .fileedit-sub,body:not(.gutenberg-editor-page) #wpfooter .about-wrap h1,body:not(.gutenberg-editor-page) #wpfooter .about-wrap .about-text,body:not(.gutenberg-editor-page) #wpfooter #bulk-titles div a:before,body:not(.gutenberg-editor-page) #wpfooter .notice-dismiss:before,body:not(.gutenberg-editor-page) #wpfooter .tagchecklist .ntdelbutton .remove-tag-icon:before,body:not(.gutenberg-editor-page) #wpfooter .welcome-panel .welcome-panel-close:before,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel .try-gutenberg-panel-close:before,body:not(.gutenberg-editor-page) #wpfooter .pressthis-js-toggle .dashicons,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel p,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel-column p.about-description,body:not(.gutenberg-editor-page) #wpfooter .howto,body:not(.gutenberg-editor-page) #wpfooter .item-type,body:not(.gutenberg-editor-page) #wpfooter .is-submenu,body:not(.gutenberg-editor-page) #wpfooter .nonessential,body:not(.gutenberg-editor-page) #wpfooter #future-posts ul span,body:not(.gutenberg-editor-page) #wpfooter #published-posts ul span,body:not(.gutenberg-editor-page) #wpfooter #dashboard-widgets h3,body:not(.gutenberg-editor-page) #wpfooter #dashboard-widgets h4,body:not(.gutenberg-editor-page) #wpfooter #dashboard_quick_press .drafts h2,body:not(.gutenberg-editor-page) #wpfooter #dashboard_right_now li a:before,body:not(.gutenberg-editor-page) #wpfooter #dashboard_right_now li span:before,body:not(.gutenberg-editor-page) #wpfooter .welcome-panel .welcome-icon:before,body:not(.gutenberg-editor-page) #wpfooter .community-events li,body:not(.gutenberg-editor-page) #wpfooter #dashboard_activity .subsubsub a .count,body:not(.gutenberg-editor-page) #wpfooter #dashboard_activity .subsubsub a.current .count,body:not(.gutenberg-editor-page) #wpfooter #latest-comments #the-comment-list .comment-meta,body:not(.gutenberg-editor-page) #wpfooter #dashboard_quick_press .drafts li time,body:not(.gutenberg-editor-page) #wpfooter #title-wrap #title-prompt-text,body:not(.gutenberg-editor-page) #wpfooter .textarea-wrap #content-prompt-text,body:not(.gutenberg-editor-page) #wpfooter #post-body ul.add-menu-item-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpfooter #post-body ul.category-tabs li.tabs a,body:not(.gutenberg-editor-page) #wpfooter #side-sortables .add-menu-item-tabs .tabs a,body:not(.gutenberg-editor-page) #wpfooter #side-sortables .category-tabs .tabs a,body:not(.gutenberg-editor-page) #wpfooter .wp-tab-bar .wp-tab-active a,body:not(.gutenberg-editor-page) #wpfooter .link-to-original,body:not(.gutenberg-editor-page) #wpfooter .accordion-section-title:after,body:not(.gutenberg-editor-page) #wpfooter .handlediv,body:not(.gutenberg-editor-page) #wpfooter .item-edit,body:not(.gutenberg-editor-page) #wpfooter .postbox .handlediv.button-link,body:not(.gutenberg-editor-page) #wpfooter .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpfooter .edit-comment-author,body:not(.gutenberg-editor-page) #wpfooter #comment-link-box,body:not(.gutenberg-editor-page) #wpfooter #edit-slug-box,body:not(.gutenberg-editor-page) #wpfooter .inactive-sidebar .description,body:not(.gutenberg-editor-page) #wpfooter .widget-holder .description,body:not(.gutenberg-editor-page) #wpfooter #available-widgets .widget-description,body:not(.gutenberg-editor-page) #wpfooter #widgets-right a.widget-control-edit,body:not(.gutenberg-editor-page) #wpfooter .in-widget-title,body:not(.gutenberg-editor-page) #wpfooter .edit-attachment-frame .attachment-info .filename,body:not(.gutenberg-editor-page) #wpfooter .attachment-details .setting span,body:not(.gutenberg-editor-page) #wpfooter .compat-item label span,body:not(.gutenberg-editor-page) #wpfooter .media-sidebar .setting span,body:not(.gutenberg-editor-page) #wpfooter .upload-plugin .install-help,body:not(.gutenberg-editor-page) #wpfooter .upload-theme .install-help,body:not(.gutenberg-editor-page) #wpfooter .subtitle").css({
	'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody ul#adminmenu a.wp-has-current-submenu:after,body:not(.gutenberg-editor-page) #wpbody ul#adminmenu>li.current>a.current:after,body:not(.gutenberg-editor-page) #wpfooter ul#adminmenu a.wp-has-current-submenu:after,body:not(.gutenberg-editor-page) #wpfooter ul#adminmenu>li.current>a.current:after").css({
	'border-right-color':'#23282d'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .comment,body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .pingback,body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .comment,body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .pingback, body:not(.gutenberg-editor-page) #wpbody #templateside>ul,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul").css({
	'background-color':getbackcolor,
	'border-color':'#32373c'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #templateside>ul li a.hover,body:not(.gutenberg-editor-page) #wpbody #templateside>ul li a:hover,body:not(.gutenberg-editor-page) #wpbody #templateside>ul li span.hover,body:not(.gutenberg-editor-page) #wpbody #templateside>ul li span:hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li a.hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li a:hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li span.hover,body:not(.gutenberg-editor-page) #wpfooter #templateside>ul li span:hover").css({
	'background-color':getbackcolor,
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody p.popular-tags,body:not(.gutenberg-editor-page) #wpbody .upload-plugin .wp-upload-form,body:not(.gutenberg-editor-page) #wpbody .upload-theme .wp-upload-form,body:not(.gutenberg-editor-page) #wpbody #screen-meta,body:not(.gutenberg-editor-page) #wpbody #contextual-help-link-wrap,body:not(.gutenberg-editor-page) #wpbody #screen-options-link-wrap,body:not(.gutenberg-editor-page) #wpbody .quicktags-toolbar,body:not(.gutenberg-editor-page) #wpbody .attachment-media-view,body:not(.gutenberg-editor-page) #wpbody .media-widget-preview.media_audio,body:not(.gutenberg-editor-page) #wpbody .media-widget-preview.media_image,body:not(.gutenberg-editor-page) #wpfooter p.popular-tags,body:not(.gutenberg-editor-page) #wpfooter .upload-plugin .wp-upload-form,body:not(.gutenberg-editor-page) #wpfooter .upload-theme .wp-upload-form,body:not(.gutenberg-editor-page) #wpfooter #screen-meta,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-link-wrap,body:not(.gutenberg-editor-page) #wpfooter #screen-options-link-wrap,body:not(.gutenberg-editor-page) #wpfooter .quicktags-toolbar,body:not(.gutenberg-editor-page) #wpfooter .attachment-media-view,body:not(.gutenberg-editor-page) #wpfooter .media-widget-preview.media_audio,body:not(.gutenberg-editor-page) #wpfooter .media-widget-preview.media_image").css({
	'background-color':getbackcolor,
	'border-color':'#191f25'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #show-settings-link,body:not(.gutenberg-editor-page) #wpbody #contextual-help-link,body:not(.gutenberg-editor-page) #wpfooter #show-settings-link,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-link").css({
	'box-shadow':'none'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #contextual-help-link-wrap,body:not(.gutenberg-editor-page) #wpbody #screen-options-link-wrap,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-link-wrap,body:not(.gutenberg-editor-page) #wpfooter #screen-options-link-wrap").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #contextual-help-link-wrap button,body:not(.gutenberg-editor-page) #wpbody #screen-options-link-wrap button,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-link-wrap button,body:not(.gutenberg-editor-page) #wpfooter #screen-options-link-wrap button").css({
	'background-color':getbackcolor,
	'border-color':'#191f25',
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #contextual-help-link-wrap button::after,body:not(.gutenberg-editor-page) #wpbody #screen-options-link-wrap button::after,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-link-wrap button::after,body:not(.gutenberg-editor-page) #wpfooter #screen-options-link-wrap button::after").css({
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #contextual-help-link-wrap button:hover,body:not(.gutenberg-editor-page) #wpbody #screen-options-link-wrap button:hover,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-link-wrap button:hover,body:not(.gutenberg-editor-page) #wpfooter #screen-options-link-wrap button:hover").css({
	'background-color':getbackcolor,
	'border-color':'#191f25',
	'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #contextual-help-link-wrap button:hover::after,body:not(.gutenberg-editor-page) #wpbody #screen-options-link-wrap button:hover::after,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-link-wrap button:hover::after,body:not(.gutenberg-editor-page) #wpfooter #screen-options-link-wrap button:hover::after").css({
	'color':'#fff'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .widgets-holder-wrap,body:not(.gutenberg-editor-page) #wpfooter .widgets-holder-wrap").css({
	'background-color':getbackcolor,
	'border-color':'transparent'
});


jQuery("body:not(.gutenberg-editor-page) #wpbody .widgets-holder-wrap .sidebar-name:hover button span,body:not(.gutenberg-editor-page) #wpfooter .widgets-holder-wrap .sidebar-name:hover button span").css({
	'border-color':'#fff'
});


jQuery("body:not(.gutenberg-editor-page) #wpbody .widgets-holder-wrap .widgets-sortables,body:not(.gutenberg-editor-page) #wpfooter .widgets-holder-wrap .widgets-sortables").css({
	'background-color':getbackcolor
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody #widgets-left .widget .widget-top:hover,body:not(.gutenberg-editor-page) #wpbody #widgets-right .widget .widget-top:hover,body:not(.gutenberg-editor-page) #wpfooter #widgets-left .widget .widget-top:hover,body:not(.gutenberg-editor-page) #wpfooter #widgets-right .widget .widget-top:hover").css({
	'border-color':'#32373c'
	
});


jQuery("body:not(.gutenberg-editor-page) #wpbody #widgets-left .widget .widget-top .widget-control-edit,body:not(.gutenberg-editor-page) #wpbody #widgets-right .widget .widget-top .widget-control-edit,body:not(.gutenberg-editor-page) #wpfooter #widgets-left .widget .widget-top .widget-control-edit,body:not(.gutenberg-editor-page) #wpfooter #widgets-right .widget .widget-top .widget-control-edit").css({
	'background-color':getbackcolor,
	'border-left-color':'transparent',
	'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page) #wpbody #widgets-left .widget .widget-top .widget-control-edit:hover,body:not(.gutenberg-editor-page) #wpbody #widgets-right .widget .widget-top .widget-control-edit:hover,body:not(.gutenberg-editor-page) #wpfooter #widgets-left .widget .widget-top .widget-control-edit:hover,body:not(.gutenberg-editor-page) #wpfooter #widgets-right .widget .widget-top .widget-control-edit:hover").css({
	'background-color':getbackcolor,
	'border-color':'23282d',
	'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page) #wpbody #widgets-left .widget ul.widgets-chooser-sidebars li.widgets-chooser-selected,body:not(.gutenberg-editor-page) #wpbody #widgets-right .widget ul.widgets-chooser-sidebars li.widgets-chooser-selected,body:not(.gutenberg-editor-page) #wpfooter #widgets-left .widget ul.widgets-chooser-sidebars li.widgets-chooser-selected,body:not(.gutenberg-editor-page) #wpfooter #widgets-right .widget ul.widgets-chooser-sidebars li.widgets-chooser-selected").css({
'background-color':getbackcolor,
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #widgets-left .widget ul.widgets-chooser-sidebars li:hover,body:not(.gutenberg-editor-page) #wpbody #widgets-right .widget ul.widgets-chooser-sidebars li:hover,body:not(.gutenberg-editor-page) #wpfooter #widgets-left .widget ul.widgets-chooser-sidebars li:hover,body:not(.gutenberg-editor-page) #wpfooter #widgets-right .widget ul.widgets-chooser-sidebars li:hover").css({
'border-color':'#191f25',
'background-color':getbackcolor,
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .contextual-help-tabs .active a,body:not(.gutenberg-editor-page) #wpfooter .contextual-help-tabs .active a").css({
'background-color':getbackcolor,
'border-color':'#32373c',
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .contextual-help-tabs a:hover,body:not(.gutenberg-editor-page) #wpfooter .contextual-help-tabs a:hover").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:active,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:focus,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:hover,body:not(.gutenberg-editor-page) #wpbody #contextual-help-wrap h5,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap h5,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap legend,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:active,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:focus,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:hover,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-wrap h5,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap h5,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap legend,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:active:hover,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:focus:hover,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:hover:hover,body:not(.gutenberg-editor-page) #wpbody #contextual-help-wrap h5:hover,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap h5:hover,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap legend:hover,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:hover,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:active:hover,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:focus:hover,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:hover:hover,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-wrap h5:hover,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap h5:hover,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap legend:hover,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:hover").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:active:hover::before,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:active:hover::after,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:focus:hover::before,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:focus:hover::after,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:hover:hover::before,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:hover:hover::after,body:not(.gutenberg-editor-page) #wpbody #contextual-help-wrap h5:hover::before,body:not(.gutenberg-editor-page) #wpbody #contextual-help-wrap h5:hover::after,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap h5:hover::before,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap h5:hover::after,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap legend:hover::before,body:not(.gutenberg-editor-page) #wpbody #screen-options-wrap legend:hover::after,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:hover::before,body:not(.gutenberg-editor-page) #wpbody #screen-meta-links .show-settings:hover::after,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:active:hover::before,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:active:hover::after,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:focus:hover::before,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:focus:hover::after,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:hover:hover::before,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:hover:hover::after,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-wrap h5:hover::before,body:not(.gutenberg-editor-page) #wpfooter #contextual-help-wrap h5:hover::after,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap h5:hover::before,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap h5:hover::after,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap legend:hover::before,body:not(.gutenberg-editor-page) #wpfooter #screen-options-wrap legend:hover::after,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:hover::before,body:not(.gutenberg-editor-page) #wpfooter #screen-meta-links .show-settings:hover::after").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel,body:not(.gutenberg-editor-page) #wpbody .welcome-panel,body:not(.gutenberg-editor-page) #wpbody .postbox,body:not(.gutenberg-editor-page) #wpbody .card,body:not(.gutenberg-editor-page) #wpbody .stuffbox,body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .comment-item,body:not(.gutenberg-editor-page) #wpbody .community-events ul,body:not(.gutenberg-editor-page) #wpbody .wp-filter,body:not(.gutenberg-editor-page) #wpbody .menu-edit #post-body,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel,body:not(.gutenberg-editor-page) #wpfooter .welcome-panel,body:not(.gutenberg-editor-page) #wpfooter .postbox,body:not(.gutenberg-editor-page) #wpfooter .card,body:not(.gutenberg-editor-page) #wpfooter .stuffbox,body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .comment-item,body:not(.gutenberg-editor-page) #wpfooter .community-events ul,body:not(.gutenberg-editor-page) #wpfooter .wp-filter,body:not(.gutenberg-editor-page) #wpfooter .menu-edit #post-body").css({
'background-color':getbackcolor,
'border-color':'#191f25',
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel p,body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel span,body:not(.gutenberg-editor-page) #wpbody .welcome-panel p,body:not(.gutenberg-editor-page) #wpbody .welcome-panel span,body:not(.gutenberg-editor-page) #wpbody .postbox p,body:not(.gutenberg-editor-page) #wpbody .postbox span,body:not(.gutenberg-editor-page) #wpbody .card p,body:not(.gutenberg-editor-page) #wpbody .card span,body:not(.gutenberg-editor-page) #wpbody .stuffbox p,body:not(.gutenberg-editor-page) #wpbody .stuffbox span,body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .comment-item p,body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .comment-item span,body:not(.gutenberg-editor-page) #wpbody .community-events ul p,body:not(.gutenberg-editor-page) #wpbody .community-events ul span,body:not(.gutenberg-editor-page) #wpbody .wp-filter p,body:not(.gutenberg-editor-page) #wpbody .wp-filter span,body:not(.gutenberg-editor-page) #wpbody .menu-edit #post-body p,body:not(.gutenberg-editor-page) #wpbody .menu-edit #post-body span,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel p,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel span,body:not(.gutenberg-editor-page) #wpfooter .welcome-panel p,body:not(.gutenberg-editor-page) #wpfooter .welcome-panel span,body:not(.gutenberg-editor-page) #wpfooter .postbox p,body:not(.gutenberg-editor-page) #wpfooter .postbox span,body:not(.gutenberg-editor-page) #wpfooter .card p,body:not(.gutenberg-editor-page) #wpfooter .card span,body:not(.gutenberg-editor-page) #wpfooter .stuffbox p,body:not(.gutenberg-editor-page) #wpfooter .stuffbox span,body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .comment-item p,body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .comment-item span,body:not(.gutenberg-editor-page) #wpfooter .community-events ul p,body:not(.gutenberg-editor-page) #wpfooter .community-events ul span,body:not(.gutenberg-editor-page) #wpfooter .wp-filter p,body:not(.gutenberg-editor-page) #wpfooter .wp-filter span,body:not(.gutenberg-editor-page) #wpfooter .menu-edit #post-body p,body:not(.gutenberg-editor-page) #wpfooter .menu-edit #post-body span").css({
'background':'#transparent'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel img,body:not(.gutenberg-editor-page) #wpbody .activity-block,body:not(.gutenberg-editor-page) #wpbody #dashboard_activity .subsubsub,body:not(.gutenberg-editor-page) #wpbody #dashboard_right_now .sub,body:not(.gutenberg-editor-page) #wpbody .community-events li:first-child,body:not(.gutenberg-editor-page) #wpbody .community-events li ~ li,body:not(.gutenberg-editor-page) #wpbody .community-events-footer,body:not(.gutenberg-editor-page) #wpbody .community-events .activity-block.last,body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel img,body:not(.gutenberg-editor-page) #wpfooter .activity-block,body:not(.gutenberg-editor-page) #wpfooter #dashboard_activity .subsubsub,body:not(.gutenberg-editor-page) #wpfooter #dashboard_right_now .sub,body:not(.gutenberg-editor-page) #wpfooter .community-events li:first-child,body:not(.gutenberg-editor-page) #wpfooter .community-events li ~ li,body:not(.gutenberg-editor-page) #wpfooter .community-events-footer,body:not(.gutenberg-editor-page) #wpfooter .community-events .activity-block.last").css({
'border-color':'#23282d'

});

jQuery("body:not(.gutenberg-editor-page) #wpbody .pressthis-bookmarklet span,body:not(.gutenberg-editor-page) #wpfooter .pressthis-bookmarklet span").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .color-option.selected,body:not(.gutenberg-editor-page) #wpbody .color-option:hover,body:not(.gutenberg-editor-page) #wpbody .accordion-section-content,body:not(.gutenberg-editor-page) #wpbody .filter-drawer,body:not(.gutenberg-editor-page) #wpbody .wp-filter .favorites-form,body:not(.gutenberg-editor-page) #wpbody .filter-group,body:not(.gutenberg-editor-page) #wpbody .filtered-by .tag,body:not(.gutenberg-editor-page) #wpfooter .color-option.selected,body:not(.gutenberg-editor-page) #wpfooter .color-option:hover,body:not(.gutenberg-editor-page) #wpfooter .accordion-section-content,body:not(.gutenberg-editor-page) #wpfooter .filter-drawer,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .favorites-form,body:not(.gutenberg-editor-page) #wpfooter .filter-group,body:not(.gutenberg-editor-page) #wpfooter .filtered-by .tag").css({
'border-color':'#191f25'

});

jQuery("body:not(.gutenberg-editor-page) #wpbody .plugin-card,body:not(.gutenberg-editor-page) #wpfooter .plugin-card").css({
'border-color':'#32373c'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .plugin-card-bottom,body:not(.gutenberg-editor-page) #wpbody .notice-warning.notice-alt,body:not(.gutenberg-editor-page) #wpbody #the-comment-list .unapproved td,body:not(.gutenberg-editor-page) #wpbody #the-comment-list .unapproved th,body:not(.gutenberg-editor-page) #wpbody #the-comment-list div.undo,body:not(.gutenberg-editor-page) #wpbody #the-comment-list tr.undo,body:not(.gutenberg-editor-page) #wpfooter .plugin-card-bottom,body:not(.gutenberg-editor-page) #wpfooter .notice-warning.notice-alt,body:not(.gutenberg-editor-page) #wpfooter #the-comment-list .unapproved td,body:not(.gutenberg-editor-page) #wpfooter #the-comment-list .unapproved th,body:not(.gutenberg-editor-page) #wpfooter #the-comment-list div.undo,body:not(.gutenberg-editor-page) #wpfooter #the-comment-list tr.undo").css({
'border-color':'#191f25'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .plugin-card,body:not(.gutenberg-editor-page) #wpbody .plugin-card-bottom,body:not(.gutenberg-editor-page) #wpbody #nav-menu-header,body:not(.gutenberg-editor-page) #wpbody #menu-management .menu-edit,body:not(.gutenberg-editor-page) #wpbody .wp-editor-container,body:not(.gutenberg-editor-page) #wpfooter .plugin-card,body:not(.gutenberg-editor-page) #wpfooter .plugin-card-bottom,body:not(.gutenberg-editor-page) #wpfooter #nav-menu-header,body:not(.gutenberg-editor-page) #wpfooter #menu-management .menu-edit,body:not(.gutenberg-editor-page) #wpfooter .wp-editor-container").css({
'border-color':'#191f25'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle,body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle::before,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle::before").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle:hover,body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle:hover::before,body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle:focus,body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle:focus::before,body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle:active,body:not(.gutenberg-editor-page) #wpbody .wp-filter .button.drawer-toggle:active::before,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle:hover,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle:hover::before,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle:focus,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle:focus::before,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle:active,body:not(.gutenberg-editor-page) #wpfooter .wp-filter .button.drawer-toggle:active::before").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .filter-links li a,body:not(.gutenberg-editor-page) #wpfooter .filter-links li a").css({
'border-color':'#32373c',
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .control-section .accordion-section-title,body:not(.gutenberg-editor-page) #wpbody .customize-pane-child .accordion-section-title,body:not(.gutenberg-editor-page) #wpbody.js .control-section .accordion-section-title:focus,body:not(.gutenberg-editor-page) #wpbody.js .control-section .accordion-section-title:hover,body:not(.gutenberg-editor-page) #wpbody.js .control-section.open .accordion-section-title,body:not(.gutenberg-editor-page) #wpbody.js .control-section:hover .accordion-section-title,body:not(.gutenberg-editor-page) #wpfooter .control-section .accordion-section-title,body:not(.gutenberg-editor-page) #wpfooter .customize-pane-child .accordion-section-title,body:not(.gutenberg-editor-page) #wpfooter.js .control-section .accordion-section-title:focus,body:not(.gutenberg-editor-page) #wpfooter.js .control-section .accordion-section-title:hover,body:not(.gutenberg-editor-page) #wpfooter.js .control-section.open .accordion-section-title,body:not(.gutenberg-editor-page) #wpfooter.js .control-section:hover .accordion-section-title").css({
'border-color':'#23282d',
'background-color':getbackcolor,
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #dashboard_right_now .sub,body:not(.gutenberg-editor-page) #wpbody .wp-tab-active,body:not(.gutenberg-editor-page) #wpbody ul.add-menu-item-tabs li.tabs,body:not(.gutenberg-editor-page) #wpbody ul.category-tabs li.tabs,body:not(.gutenberg-editor-page) #wpbody .categorydiv div.tabs-panel,body:not(.gutenberg-editor-page) #wpbody .customlinkdiv div.tabs-panel,body:not(.gutenberg-editor-page) #wpbody .posttypediv div.tabs-panel,body:not(.gutenberg-editor-page) #wpbody .taxonomydiv div.tabs-panel,body:not(.gutenberg-editor-page) #wpbody .wp-tab-panel,body:not(.gutenberg-editor-page) #wpfooter #dashboard_right_now .sub,body:not(.gutenberg-editor-page) #wpfooter .wp-tab-active,body:not(.gutenberg-editor-page) #wpfooter ul.add-menu-item-tabs li.tabs,body:not(.gutenberg-editor-page) #wpfooter ul.category-tabs li.tabs,body:not(.gutenberg-editor-page) #wpfooter .categorydiv div.tabs-panel,body:not(.gutenberg-editor-page) #wpfooter .customlinkdiv div.tabs-panel,body:not(.gutenberg-editor-page) #wpfooter .posttypediv div.tabs-panel,body:not(.gutenberg-editor-page) #wpfooter .taxonomydiv div.tabs-panel,body:not(.gutenberg-editor-page) #wpfooter .wp-tab-panel").css({
'background-color':getbackcolor,
'border-color':'#32373c'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .accordion-section,body:not(.gutenberg-editor-page) #wpbody .accordion-section.open:hover,body:not(.gutenberg-editor-page) #wpbody #menu-management .menu-edit,body:not(.gutenberg-editor-page) #wpbody #menu-settings-column .accordion-container,body:not(.gutenberg-editor-page) #wpbody .comment-ays,body:not(.gutenberg-editor-page) #wpbody .feature-filter,body:not(.gutenberg-editor-page) #wpbody .imgedit-group,body:not(.gutenberg-editor-page) #wpbody .manage-menus,body:not(.gutenberg-editor-page) #wpbody .menu-item-handle,body:not(.gutenberg-editor-page) #wpbody .popular-tags,body:not(.gutenberg-editor-page) #wpbody .stuffbox,body:not(.gutenberg-editor-page) #wpbody .widget-inside,body:not(.gutenberg-editor-page) #wpbody .widget-top,body:not(.gutenberg-editor-page) #wpbody p.popular-tags,body:not(.gutenberg-editor-page) #wpbody .postbox .hndle,body:not(.gutenberg-editor-page) #wpbody .stuffbox .hndle,body:not(.gutenberg-editor-page) #wpbody .widgets-chooser ul,body:not(.gutenberg-editor-page) #wpfooter .accordion-section,body:not(.gutenberg-editor-page) #wpfooter .accordion-section.open:hover,body:not(.gutenberg-editor-page) #wpfooter #menu-management .menu-edit,body:not(.gutenberg-editor-page) #wpfooter #menu-settings-column .accordion-container,body:not(.gutenberg-editor-page) #wpfooter .comment-ays,body:not(.gutenberg-editor-page) #wpfooter .feature-filter,body:not(.gutenberg-editor-page) #wpfooter .imgedit-group,body:not(.gutenberg-editor-page) #wpfooter .manage-menus,body:not(.gutenberg-editor-page) #wpfooter .menu-item-handle,body:not(.gutenberg-editor-page) #wpfooter .popular-tags,body:not(.gutenberg-editor-page) #wpfooter .stuffbox,body:not(.gutenberg-editor-page) #wpfooter .widget-inside,body:not(.gutenberg-editor-page) #wpfooter .widget-top,body:not(.gutenberg-editor-page) #wpfooter p.popular-tags,body:not(.gutenberg-editor-page) #wpfooter .postbox .hndle,body:not(.gutenberg-editor-page) #wpfooter .stuffbox .hndle,body:not(.gutenberg-editor-page) #wpfooter .widgets-chooser ul").css({
'background-color':getbackcolor,
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #major-publishing-actions,body:not(.gutenberg-editor-page) #wpbody .menu-item-settings,body:not(.gutenberg-editor-page) #wpbody .link-to-original,body:not(.gutenberg-editor-page) #wpbody.nav-menus-php #post-body,body:not(.gutenberg-editor-page) #wpfooter #major-publishing-actions,body:not(.gutenberg-editor-page) #wpfooter .menu-item-settings,body:not(.gutenberg-editor-page) #wpfooter .link-to-original,body:not(.gutenberg-editor-page) #wpfooter.nav-menus-php #post-body").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .accordion-section-title:hover:after,body:not(.gutenberg-editor-page) #wpbody .handlediv:focus,body:not(.gutenberg-editor-page) #wpbody .handlediv:hover,body:not(.gutenberg-editor-page) #wpbody .item-edit:focus,body:not(.gutenberg-editor-page) #wpbody .item-edit:hover,body:not(.gutenberg-editor-page) #wpbody .postbox .handlediv.button-link:focus,body:not(.gutenberg-editor-page) #wpbody .postbox .handlediv.button-link:hover,body:not(.gutenberg-editor-page) #wpbody .sidebar-name:hover .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpbody .widget-action:focus,body:not(.gutenberg-editor-page) #wpbody .widget-top:hover .widget-action,body:not(.gutenberg-editor-page) #wpfooter .accordion-section-title:hover:after,body:not(.gutenberg-editor-page) #wpfooter .handlediv:focus,body:not(.gutenberg-editor-page) #wpfooter .handlediv:hover,body:not(.gutenberg-editor-page) #wpfooter .item-edit:focus,body:not(.gutenberg-editor-page) #wpfooter .item-edit:hover,body:not(.gutenberg-editor-page) #wpfooter .postbox .handlediv.button-link:focus,body:not(.gutenberg-editor-page) #wpfooter .postbox .handlediv.button-link:hover,body:not(.gutenberg-editor-page) #wpfooter .sidebar-name:hover .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpfooter .widget-action:focus,body:not(.gutenberg-editor-page) #wpfooter .widget-top:hover .widget-action").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .accordion-section,body:not(.gutenberg-editor-page) #wpbody .accordion-section.open:hover,body:not(.gutenberg-editor-page) #wpbody #menu-management .menu-edit,body:not(.gutenberg-editor-page) #wpbody #menu-settings-column .accordion-container,body:not(.gutenberg-editor-page) #wpbody .comment-ays,body:not(.gutenberg-editor-page) #wpbody .feature-filter,body:not(.gutenberg-editor-page) #wpbody .imgedit-group,body:not(.gutenberg-editor-page) #wpbody .manage-menus,body:not(.gutenberg-editor-page) #wpbody .menu-item-handle,body:not(.gutenberg-editor-page) #wpbody .popular-tags,body:not(.gutenberg-editor-page) #wpbody .stuffbox,body:not(.gutenberg-editor-page) #wpbody .widget-inside,body:not(.gutenberg-editor-page) #wpbody .widget-top,body:not(.gutenberg-editor-page) #wpbody p.popular-tags,body:not(.gutenberg-editor-page) #wpbody .postbox .hndle,body:not(.gutenberg-editor-page) #wpbody .stuffbox .hndle,body:not(.gutenberg-editor-page) #wpbody .widgets-chooser ul,body:not(.gutenberg-editor-page) #wpfooter .accordion-section,body:not(.gutenberg-editor-page) #wpfooter .accordion-section.open:hover,body:not(.gutenberg-editor-page) #wpfooter #menu-management .menu-edit,body:not(.gutenberg-editor-page) #wpfooter #menu-settings-column .accordion-container,body:not(.gutenberg-editor-page) #wpfooter .comment-ays,body:not(.gutenberg-editor-page) #wpfooter .feature-filter,body:not(.gutenberg-editor-page) #wpfooter .imgedit-group,body:not(.gutenberg-editor-page) #wpfooter .manage-menus,body:not(.gutenberg-editor-page) #wpfooter .menu-item-handle,body:not(.gutenberg-editor-page) #wpfooter .popular-tags,body:not(.gutenberg-editor-page) #wpfooter .stuffbox,body:not(.gutenberg-editor-page) #wpfooter .widget-inside,body:not(.gutenberg-editor-page) #wpfooter .widget-top,body:not(.gutenberg-editor-page) #wpfooter p.popular-tags,body:not(.gutenberg-editor-page) #wpfooter .postbox .hndle,body:not(.gutenberg-editor-page) #wpfooter .stuffbox .hndle,body:not(.gutenberg-editor-page) #wpfooter .widgets-chooser ul").css({
'border-color':'#23282d'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #major-publishing-actions,body:not(.gutenberg-editor-page) #wpbody .menu-item-settings,body:not(.gutenberg-editor-page) #wpbody .link-to-original,body:not(.gutenberg-editor-page) #wpbody.nav-menus-php #post-body,body:not(.gutenberg-editor-page) #wpfooter #major-publishing-actions,body:not(.gutenberg-editor-page) #wpfooter .menu-item-settings,body:not(.gutenberg-editor-page) #wpfooter .link-to-original,body:not(.gutenberg-editor-page) #wpfooter.nav-menus-php #post-body").css({
'background':getbackcolor,
'border-color':'#23282d'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .accordion-section-title:hover:after,body:not(.gutenberg-editor-page) #wpbody .handlediv:focus,body:not(.gutenberg-editor-page) #wpbody .handlediv:hover,body:not(.gutenberg-editor-page) #wpbody .item-edit:focus,body:not(.gutenberg-editor-page) #wpbody .item-edit:hover,body:not(.gutenberg-editor-page) #wpbody .postbox .handlediv.button-link:focus,body:not(.gutenberg-editor-page) #wpbody .postbox .handlediv.button-link:hover,body:not(.gutenberg-editor-page) #wpbody .sidebar-name:hover .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpbody .widget-action:focus,body:not(.gutenberg-editor-page) #wpbody .widget-top:hover .widget-action,body:not(.gutenberg-editor-page) #wpfooter .accordion-section-title:hover:after,body:not(.gutenberg-editor-page) #wpfooter .handlediv:focus,body:not(.gutenberg-editor-page) #wpfooter .handlediv:hover,body:not(.gutenberg-editor-page) #wpfooter .item-edit:focus,body:not(.gutenberg-editor-page) #wpfooter .item-edit:hover,body:not(.gutenberg-editor-page) #wpfooter .postbox .handlediv.button-link:focus,body:not(.gutenberg-editor-page) #wpfooter .postbox .handlediv.button-link:hover,body:not(.gutenberg-editor-page) #wpfooter .sidebar-name:hover .sidebar-name-arrow,body:not(.gutenberg-editor-page) #wpfooter .widget-action:focus,body:not(.gutenberg-editor-page) #wpfooter .widget-top:hover .widget-action").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .menu-item-handle,body:not(.gutenberg-editor-page) #wpbody .widget .widget-top,body:not(.gutenberg-editor-page) #wpbody .widget-inside,body:not(.gutenberg-editor-page) #wpbody .manage-menus,body:not(.gutenberg-editor-page) #wpbody #menu-management,body:not(.gutenberg-editor-page) #wpfooter .menu-item-handle,body:not(.gutenberg-editor-page) #wpfooter .widget .widget-top,body:not(.gutenberg-editor-page) #wpfooter .widget-inside,body:not(.gutenberg-editor-page) #wpfooter .manage-menus,body:not(.gutenberg-editor-page) #wpfooter #menu-management").css({
'background':getbackcolor,
'border-color':'#32373c'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .menu-item-bar .menu-item-handle,body:not(.gutenberg-editor-page) #wpbody .menu-item-bar .menu-item-handle:hover,body:not(.gutenberg-editor-page) #wpfooter .menu-item-bar .menu-item-handle,body:not(.gutenberg-editor-page) #wpfooter .menu-item-bar .menu-item-handle:hover").css({
'background':getbackcolor,
'border-color':'#23282d'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody #major-publishing-actions,body:not(.gutenberg-editor-page) #wpbody .menu-item-settings,body:not(.gutenberg-editor-page) #wpbody .link-to-original,body:not(.gutenberg-editor-page) #wpbody.nav-menus-php #post-body,body:not(.gutenberg-editor-page) #wpfooter #major-publishing-actions,body:not(.gutenberg-editor-page) #wpfooter .menu-item-settings,body:not(.gutenberg-editor-page) #wpfooter .link-to-original,body:not(.gutenberg-editor-page) #wpfooter.nav-menus-php #post-body").css({

'border-color':'#23282d'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .wp-editor-container,body:not(.gutenberg-editor-page) #wpbody .wp-editor-expand #post-status-info,body:not(.gutenberg-editor-page) #wpfooter .wp-editor-container,body:not(.gutenberg-editor-page) #wpfooter .wp-editor-expand #post-status-info").css({

'border-color':'#32373c'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .nav-tab-wrapper,body:not(.gutenberg-editor-page) #wpbody .wrap h2.nav-tab-wrapper,body:not(.gutenberg-editor-page) #wpbody h1.nav-tab-wrapper,body:not(.gutenberg-editor-page) #wpfooter .nav-tab-wrapper,body:not(.gutenberg-editor-page) #wpfooter .wrap h2.nav-tab-wrapper,body:not(.gutenberg-editor-page) #wpfooter h1.nav-tab-wrapper").css({

'border-color':'#bbc8d4'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .nav-tab,body:not(.gutenberg-editor-page) #wpfooter .nav-tab").css({
'background-color':getbackcolor,
'border-color':'#191f25',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .nav-tab:focus,body:not(.gutenberg-editor-page) #wpbody .nav-tab:hover,body:not(.gutenberg-editor-page) #wpfooter .nav-tab:focus,body:not(.gutenberg-editor-page) #wpfooter .nav-tab:hover").css({
'background':getbackcolor,

});
jQuery("body:not(.gutenberg-editor-page) #wpbody .nav-tab-active,body:not(.gutenberg-editor-page) #wpbody .nav-tab-active:focus,body:not(.gutenberg-editor-page) #wpbody .nav-tab-active:focus:active,body:not(.gutenberg-editor-page) #wpbody .nav-tab-active:hover,body:not(.gutenberg-editor-page) #wpbody .about-wrap h2 .nav-tab-active,body:not(.gutenberg-editor-page) #wpbody .media-modal-content,body:not(.gutenberg-editor-page) #wpfooter .nav-tab-active,body:not(.gutenberg-editor-page) #wpfooter .nav-tab-active:focus,body:not(.gutenberg-editor-page) #wpfooter .nav-tab-active:focus:active,body:not(.gutenberg-editor-page) #wpfooter .nav-tab-active:hover,body:not(.gutenberg-editor-page) #wpfooter .about-wrap h2 .nav-tab-active,body:not(.gutenberg-editor-page) #wpfooter .media-modal-content").css({
'background-color':getbackcolor,
'border-color':'#bbc8d4',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .media-frame-content,body:not(.gutenberg-editor-page) #wpbody .edit-attachment-frame .attachment-info,body:not(.gutenberg-editor-page) #wpfooter .media-frame-content,body:not(.gutenberg-editor-page) #wpfooter .edit-attachment-frame .attachment-info").css({
'background-color':getbackcolor,
'border-color':'#32373c',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .edit-attachment-frame .edit-media-header .left,body:not(.gutenberg-editor-page) #wpbody .edit-attachment-frame .edit-media-header .right,body:not(.gutenberg-editor-page) #wpbody.upload-php .media-modal-close,body:not(.gutenberg-editor-page) #wpfooter .edit-attachment-frame .edit-media-header .left,body:not(.gutenberg-editor-page) #wpfooter .edit-attachment-frame .edit-media-header .right,body:not(.gutenberg-editor-page) #wpfooter.upload-php .media-modal-close").css({

'border-color':'#23282d'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody #template textarea,body:not(.gutenberg-editor-page) #wpfooter #template textarea").css({

'border-color':'#32373c',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-backdrop,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-wrap,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-backdrop,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-wrap, body:not(.gutenberg-editor-page) #wpbody .theme-overlay .screenshot,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .screenshot").css({
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-overlay .current-label,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .current-label, body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-name,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-version,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-author,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-description,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-name,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-version,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-author,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-description").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-tags,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-tags, body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-tags span,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-tags span, body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .close,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .left,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .right,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .close,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .left,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .right").css({
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header:before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .close:before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .left:before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .right:before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header:before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .close:before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .left:before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .right:before").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header:hover::before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .close:hover::before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .left:hover::before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .right:hover::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header:hover::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .close:hover::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .left:hover::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .right:hover::before").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header.disabled::before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .close.disabled::before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .left.disabled::before,body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-header .right.disabled::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header.disabled::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .close.disabled::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .left.disabled::before,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-header .right.disabled::before").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-overlay .theme-actions,body:not(.gutenberg-editor-page) #wpfooter .theme-overlay .theme-actions").css({
'background-color':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-browser .theme,body:not(.gutenberg-editor-page) #wpfooter .theme-browser .theme").css({
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-browser .theme .theme-name,body:not(.gutenberg-editor-page) #wpbody .theme-browser .theme .theme-actions,body:not(.gutenberg-editor-page) #wpbody .theme-browser .theme .theme-screenshot,body:not(.gutenberg-editor-page) #wpfooter .theme-browser .theme .theme-name,body:not(.gutenberg-editor-page) #wpfooter .theme-browser .theme .theme-actions,body:not(.gutenberg-editor-page) #wpfooter .theme-browser .theme .theme-screenshot").css({
'border-color':'#32373c'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody #the-comment-list .approve a,body:not(.gutenberg-editor-page) #wpfooter #the-comment-list .approve a").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link h1").css({
'background-color':'#23282d',
'border-color':'#191f25',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector").css({
'border-color':'#32373c'
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector .howto").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector .query-results").css({
'border-color':'#191f25',
'background-color':getbackcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector .query-notice").css({
'border-bottom-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) #wpbody .theme-browser .theme.active .theme-name::after,body:not(.gutenberg-editor-page) #wpbody .theme-browser .theme.add-new-theme a:focus::after,body:not(.gutenberg-editor-page) #wpbody .theme-browser .theme.add-new-theme a:hover::after,body:not(.gutenberg-editor-page) #wpfooter .theme-browser .theme.active .theme-name::after,body:not(.gutenberg-editor-page) #wpfooter .theme-browser .theme.add-new-theme a:focus::after,body:not(.gutenberg-editor-page) #wpfooter .theme-browser .theme.add-new-theme a:hover::after").css({
'border-color':'#32373c'
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector .query-notice .query-notice-default,body:not(.gutenberg-editor-page) #wp-link #link-selector .query-notice .query-notice-hint").css({
'color':gettextcolor,
'background-color':getbackcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector ul li").css({
'border-color':'#191f25',
'background-color':getbackcolor,
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector ul li span").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link #link-selector ul li.selected,body:not(.gutenberg-editor-page) #wp-link #link-selector ul li:hover,body:not(.gutenberg-editor-page) #wp-link #link-selector ul li:focus").css({
'border-color':'#23282d',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #wp-link .submitbox").css({
'background-color':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) div.mce-inline-toolbar-grp .wp-link-preview a").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) div.mce-inline-toolbar-grp .wp-link-preview a:hover,body:not(.gutenberg-editor-page) div.mce-inline-toolbar-grp .wp-link-preview a:focus").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) div.mce-inline-toolbar-grp.mce-arrow-up::before").css({
	'border-bottom-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) div.mce-inline-toolbar-grp.mce-arrow-up::after").css({
	'border-bottom-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page).wp-customizer #screen-options-wrap").css({
'background-color':getbackcolor,
'border-color':'#23282d'
});

jQuery("body:not(.gutenberg-editor-page).wp-customizer .menu-item-settings,body:not(.gutenberg-editor-page).wp-customizer .menu-item-bar .menu-item-handle").css({
'background-color':getbackcolor,
'border-color':'#191f25',
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-tabs").css({
'background-color':getbackcolor,
'border-color':'#32373c'

});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-tabs a.current").css({
'background-color':getbackcolor,
'border-color':'#32373c',
'border-bottom-color':'#23282d',
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-conten").css({
'background-color':getbackcolor,

});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-content .wrap").css({
'background-color':getbackcolor,

});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-content .fyi").css({
'background':getbackcolor,
'border-color':'#32373c',
'color':gettextcolor

});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-content .fyi .counter-back").css({
'background':getbackcolor

});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-content .fyi h3,body:not(.gutenberg-editor-page) #plugin-information-scrollable #plugin-information-content .fyi strong").css({
'color':gettextcolor+'!important'
});

jQuery("body:not(.gutenberg-editor-page) #plugin-information-footer, body:not(.gutenberg-editor-page) #customize-controls").css({
'border-color':'#23282d'
});

jQuery("body:not(.gutenberg-editor-page) #customize-controls .cannot-expand:hover .accordion-section-title,body:not(.gutenberg-editor-page) #customize-controls .panel-meta.customize-info .accordion-section-title:hover,body:not(.gutenberg-editor-page) #customize-controls .customize-info .customize-panel-description,body:not(.gutenberg-editor-page) #customize-controls .customize-info .customize-section-description,body:not(.gutenberg-editor-page) #customize-controls .no-widget-areas-rendered-notice,body:not(.gutenberg-editor-page) #customize-controls #customize-outer-theme-controls .customize-info .customize-section-description").css({
'background-color':getbackcolor,
'border-color':'#191f25',
'color':gettextcolor});

jQuery("body:not(.gutenberg-editor-page) #customize-controls .control-section .accordion-section-title:focus .menu-in-location,body:not(.gutenberg-editor-page) #customize-controls .control-section .accordion-section-title:hover .menu-in-location,body:not(.gutenberg-editor-page) #customize-controls .theme-location-set").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) #customize-controls #customize-sidebar-outer-conten").css({
'background-color':getbackcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .customize-panel-back,body:not(.gutenberg-editor-page) #customize-controls .customize-section-back").css({
'background-color':getbackcolor,
'border-color':'transparent',
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls .control-panel-content:not(.control-panel-nav_menus) .control-section:nth-child(2),body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls .control-panel-nav_menus .control-section-nav_menu,body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls .control-section-nav_menu_locations .accordion-section-title,body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls #accordion-section-menu_locations>.accordion-section-title,body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls .control-section:last-of-type.open,body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls .control-section:last-of-type>.accordion-section-title,body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls .control-section.open").css({
'boder-color':'#191f25'

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .control-section .accordion-section-title:focus,body:not(.gutenberg-editor-page) #customize-controls .control-section .accordion-section-title:hover,body:not(.gutenberg-editor-page) #customize-controls .control-section.open .accordion-section-title,body:not(.gutenberg-editor-page) #customize-controls .control-section:hover>.accordion-section-title").css({
'background-color':getbackcolor,
'border-color':'#32373c',
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .control-section .accordion-section-title:focus::after,body:not(.gutenberg-editor-page) #customize-controls .control-section .accordion-section-title:hover::after,body:not(.gutenberg-editor-page) #customize-controls .control-section.open .accordion-section-title::after,body:not(.gutenberg-editor-page) #customize-controls .control-section:hover>.accordion-section-title::after").css({
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .accordion-section-title,body:not(.gutenberg-editor-page) #customize-controls .customize-section-title").css({
'background-color':getbackcolor,
'border-color':'#191f25',
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .accordion-section-title:hover,body:not(.gutenberg-editor-page) #customize-controls .customize-section-title:hover").css({
'background-color':getbackcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .accordion-section-title h3,body:not(.gutenberg-editor-page) #customize-controls .customize-section-title h3").css({
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .customize-info").css({
'border-color':'#32373c'

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .customize-info .customize-help-toggle").css({
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .customize-info .accordion-section-title,body:not(.gutenberg-editor-page) #customize-controls .customize-info .customize-panel-description").css({
'color':gettextcolor,
'background-color':getbackcolor,
'border-color':'#32373c'

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls #customize-theme-controls .control-panel-themes>.accordion-section-title").css({
'color':gettextcolor,
'background-color':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) #customize-controls #customize-header-actions,body:not(.gutenberg-editor-page) #customize-controls .customize-controls-close").css({
'color':gettextcolor,
'background-color':getbackcolor,
'border-color':'#23282d'
});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .customize-controls-close").css({
'color':'#bbc8d4',
'border-color':'transparent'
});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .customize-controls-close:hover").css({
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .wp-full-overlay-sidebar-content").css({
'background-color':getbackcolor
});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .collapse-sidebar-arrow::before").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) #customize-controls .collapse-sidebar span").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal button.media-modal-close").css({
'background-color':getbackcolor,
'border-color':'#23282d'
});
jQuery("body:not(.body:not(.gutenberg-editor-page) .media-modal button.media-modal-close:hover").css({
'background-color':getbackcolor,
'border-color':'#50626f'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal button.media-modal-close:hover span::before").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal button.media-modal-close span::before").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-menu").css({
'background':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-menu a").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-menu a:hover").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-menu .separator").css({
'border-color':'#50626f'

});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-router a:hover").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-router a").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-menu .active,body:not(.gutenberg-editor-page) .media-modal .media-menu .active:hover").css({
'color':'#fff'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-router .active").css({
'color':gettextcolor,
'background':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-sidebar").css({
'color':gettextcolor,
'background':getbackcolor,
'border-color':'#fff',
'border-left-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-sidebar .setting span").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-sidebar h2").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-sidebar .attachment-info").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-sidebar .attachment-info .details").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-sidebar .attachment-info .filename").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal .media-selection:after").css({
'background-image':'none'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content").css({
'color':gettextcolor,
'background-color':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .media-frame-title,body:not(.gutenberg-editor-page) .media-modal-content .media-frame-content").css({

'background-color':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .media-frame-title h1,body:not(.gutenberg-editor-page) .media-modal-content .media-frame-content h1").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .media-frame-content .setting span").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .media-frame-content .upload-ui h2,body:not(.gutenberg-editor-page) .media-modal-content .media-frame-content .upload-ui p").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .media-frame-toolbar .media-toolbar").css({
'color':'gettextcolor'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .media-frame.hide-router .media-frame-title").css({
'border-bottom':'none'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .imgedit-wrap .imgedit-settings").css({
'background-color':getbackcolor,
'border-color':'#50626f'
});
jQuery("body:not(.gutenberg-editor-page) .media-modal-content .edit-media-header").css({
'background-color':getbackcolor
});


jQuery("body:not(.gutenberg-editor-page) .media-modal-content .edit-media-header button").css({
'color':gettextcolor,
'background-color':getbackcolor
});


jQuery("body:not(.gutenberg-editor-page) .media-modal-content .edit-media-header button::before").css({
'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page) .media-modal-content .attachment-media-view").css({
'background-color':getbackcolor
});


jQuery("body:not(.gutenberg-editor-page) .media-modal-content .edit-attachment-frame .edit-media-header .left,body:not(.gutenberg-editor-page) .media-modal-content .edit-attachment-frame .edit-media-header .right").css({
'background-color':getbackcolor,
'border-color':'#50626f'
});


jQuery("body:not(.gutenberg-editor-page) .media-modal-content .edit-attachment-frame .attachment-info").css({
'color':gettextcolor,
'background-color':getbackcolor,
'border-color':'#50626f'
});


jQuery("body:not(.gutenberg-editor-page) .media-modal-content .edit-attachment-frame .attachment-info span,body:not(.gutenberg-editor-page) .media-modal-content .edit-attachment-frame .attachment-info .filename").css({
'color':gettextcolor
});


jQuery("body:not(.gutenberg-editor-page) .media-modal .wp-core-ui .attachment-previ").css({
'color':gettextcolor,
'background':getbackcolor,
'box-shadow':'inset 0 0 15px rgba(0,0,0,0.2),inset 0 0 0 1px rgba(0,0,0,0.05'
});


jQuery("body:not(.gutenberg-editor-page) .media-modal .wp-core-ui .attachment.selected").css({
'box-shadow':'inset 0 0 0 5px #50626f,inset 0 0 0 7px #ccc'
});


jQuery("body:not(.gutenberg-editor-page) .media-modal .wp-core-ui .attachment:focus,body:not(.gutenberg-editor-page) .media-modal .wp-core-ui .attachment.details, body:not(.gutenberg-editor-page) .media-modal .embed-url").css({
'background':getbackcolor
});


jQuery("body:not(.gutenberg-editor-page) #file-editor-warning").css({
'color':gettextcolor,
'background-color':getbackcolor
});


jQuery("body:not(.gutenberg-editor-page) #adminmenu a.wp-has-current-submenu:after,body:not(.gutenberg-editor-page) #adminmenu>li.current>a.current:after").css({
'border-right-color':'#23282d'

});


jQuery("body:not(.gutenberg-editor-page) .notice,body:not(.gutenberg-editor-page) .error,body:not(.gutenberg-editor-page) .updated").css({
'background-color':getbackcolor

});


jQuery("body:not(.gutenberg-editor-page) .wp-editor-tabs button").css({
'background-color':'#50626f',
'border-color':getbackcolor,
'border-bottom':'none',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .wp-editor-tabs button:hover,body:not(.gutenberg-editor-page) .wp-editor-tabs button:focus").css({
'background-color':getbackcolor,
'border-color':'#32373c',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .html-active .wp-editor-tabs button.switch-html").css({
'background-color':getbackcolor,
'border-color':'#32373c',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) .tmce-active .wp-editor-tabs button.switch-tmce").css({
'background-color':getbackcolor,
'border-color':'#32373c',
'color':gettextcolor

});
jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar-grp").css({
'background-color':getbackcolor,
'border-color':'#191f25',
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn").css({
'background':getbackcolor,
'border-color':'transparent'
});
jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn i").css({
'color':gettextcolor
});
jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-disabled:hover,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-disabled:focus").css({
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox").css({
'background-color':getbackcolor,
'border-color':'#191f25'
});
jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox span").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox i").css({
'border-top-color':'#bbc8d4'
});

jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox.mce-active,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox:hover,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox:focus").css({
'background-color':getbackcolor,
'border-color':'#191f25'

});

jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox.mce-active span,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox:hover span,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox:focus span").css({
'border-color':'#fff'
});

jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox.mce-active i,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox:hover i,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox:focus i").css({
'border-top-color':'#bbc8d4'
});

jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-listbox.mce-active i").css({

'border-bottom-color':'#bbc8d4'

});

jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-active,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn:hover,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn:focus").css({
'background':getbackcolor,
'border-color':'#191f25',
'box-shadow':'none'
});

jQuery("body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn.mce-active i,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn:hover i,body:not(.gutenberg-editor-page) div.mce-toolbar .mce-btn-group .mce-btn:focus i").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) div.mce-panel").css({
'border-color':'#191f25'
});

jQuery("body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item .mce-ico,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item .mce-text").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item.mce-active,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item.mce-selected,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item:focus,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item:hover").css({
'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item.mce-active .mce-ico,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item.mce-active .mce-text,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item.mce-selected .mce-ico,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item.mce-selected .mce-text,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item:focus .mce-ico,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item:focus .mce-text,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item:hover .mce-ico,body:not(.gutenberg-editor-page) div.mce-panel .mce-menu-item:hover .mce-text").css({
'background-color':'#fff'
});

jQuery("body:not(.gutenberg-editor-page) .wp-pointer-content").css({
'background-color':getbackcolor,
'color':gettextcolor,
'border-color':'#191f25'
});

jQuery("body:not(.gutenberg-editor-page) .wp-pointer-content h3").css({
'border-color':'#191f25'
});


jQuery("body:not(.gutenberg-editor-page) .wp-pointer-buttons a.close,body:not(.gutenberg-editor-page) .wp-pointer-buttons a.close::before").css({
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) .wp-pointer-buttons a.close:hover,body:not(.gutenberg-editor-page) .wp-pointer-buttons a.close:hover::before").css({
'color':gettextcolor
});

// jQuery("body:not").css({
// 	'border-right-color':'#191f25'
// });

jQuery("body:not(.gutenberg-editor-page) .wp-pointer-left .wp-pointer-arrow").css({
	'border-right-color':'#191f25'
});

jQuery("body:not(.gutenberg-editor-page) .CodeMirror").css({
'background-color':getbackcolor,
'border-color':'#191f25',
'color':gettextcolor
});

jQuery("body:not(.gutenberg-editor-page) .CodeMirror-gutter").css({
'background-color':getbackcolor,
'border-color':'#191f25'
});

jQuery("body:not(.gutenberg-editor-page) .CodeMirror-activeline-background").css({
'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) .CodeMirror-linenumber").css({
'border-color':'#23282d'
});

jQuery("body:not(.gutenberg-editor-page) .CodeMirror-code .cm-tag,body:not(.gutenberg-editor-page) .CodeMirror-code .cm-builtin,body:not(.gutenberg-editor-page) .CodeMirror-code .cm-qualifier").css({
'color':gettextcolor
});



jQuery("#activity-widget #latest-comments #the-comment-list .comment-item").css({
'color':gettextcolor,
'background':getbackcolor
});




jQuery("body:not(.gutenberg-editor-page) .CodeMirror-gutters").css({
'border-color':'#23282d'
});

jQuery(".wrap .add-new-h2, .wrap .add-new-h2:active, .wrap .page-title-action, .wrap .page-title-action:active").css({
'background-color':getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .wp-filter").css({
'background-color':getbackcolor+'!important',
'border-color':'#191f25 !important',
'color':gettextcolor+' !important',
});

// jQuery("#adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap").css({
// 'width': '160px',
// 'background-color': getbackcolor
// });
jQuery("#quick-press textarea#content").css({
'background-color': getbackcolor
});

jQuery("body:not(.gutenberg-editor-page) #titlediv #title, body:not(.gutenberg-editor-page) input[type=text], body:not(.gutenberg-editor-page) input[type=search], body:not(.gutenberg-editor-page) input[type=radio], body:not(.gutenberg-editor-page) input[type=tel], body:not(.gutenberg-editor-page) input[type=time], body:not(.gutenberg-editor-page) input[type=url], body:not(.gutenberg-editor-page) input[type=week], body:not(.gutenberg-editor-page) input[type=password], body:not(.gutenberg-editor-page) input[type=checkbox], body:not(.gutenberg-editor-page) input[type=color], body:not(.gutenberg-editor-page) input[type=date], body:not(.gutenberg-editor-page) input[type=datetime], body:not(.gutenberg-editor-page) input[type=datetime-local], body:not(.gutenberg-editor-page) input[type=email], body:not(.gutenberg-editor-page) input[type=month], body:not(.gutenberg-editor-page) input[type=number], body:not(.gutenberg-editor-page) select, body:not(.gutenberg-editor-page) textarea").css({
'background-color': getbackcolor +'!important',
'border-color':' #191f25 !important',
'color': gettextcolor+'!important'
});

jQuery("body:not(.gutenberg-editor-page) #wpbody .try-gutenberg-panel, body:not(.gutenberg-editor-page) #wpbody .welcome-panel, body:not(.gutenberg-editor-page) #wpbody .postbox, body:not(.gutenberg-editor-page) #wpbody .card, body:not(.gutenberg-editor-page) #wpbody .stuffbox, body:not(.gutenberg-editor-page) #wpbody #activity-widget #the-comment-list .comment-item, body:not(.gutenberg-editor-page) #wpbody .community-events ul, body:not(.gutenberg-editor-page) #wpbody .wp-filter, body:not(.gutenberg-editor-page) #wpbody .menu-edit #post-body, body:not(.gutenberg-editor-page) #wpfooter .try-gutenberg-panel, body:not(.gutenberg-editor-page) #wpfooter .welcome-panel, body:not(.gutenberg-editor-page) #wpfooter .postbox, body:not(.gutenberg-editor-page) #wpfooter .card, body:not(.gutenberg-editor-page) #wpfooter .stuffbox, body:not(.gutenberg-editor-page) #wpfooter #activity-widget #the-comment-list .comment-item, body:not(.gutenberg-editor-page) #wpfooter .community-events ul, body:not(.gutenberg-editor-page) #wpfooter .wp-filter, body:not(.gutenberg-editor-page) #wpfooter .menu-edit #post-body").css({
'background-color': getbackcolor,
'border-color': '#191f25',
'color': gettextcolor
});