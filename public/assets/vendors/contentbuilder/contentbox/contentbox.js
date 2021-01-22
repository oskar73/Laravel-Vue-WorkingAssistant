/*
ContentBox.js ver.4.0.4
*/

(function (jQuery) {

    var $activeSection;
    var $activeBox;
    var scriptPath = currentScriptPath();
    var _fb;
    var bLangFile = false;
    if (typeof _txt !== 'undefined') {
        bLangFile = true;
    }
    var bSideSnippets = false;

    jQuery.contentbox = function (element, options) {

        var defaults = {
            scriptPath: '',
            assetPath: 'assets/',
            modulePath: 'assets/modules/',
            designPath: 'assets/designs/',
            contentStylePath: 'assets/styles/',
            snippetData: 'assets/minimalist-blocks/snippetlist.html',
            pluginPath: '',
            fontAssetPath: 'assets/fonts/',
            enableContentStyle: true,
            imageselect: '',
            fileselect: '',
            onRender: function () { },
            onChange: function () { },
            onCoverImageSelectClick: null,
            // onImageBrowseClick: function () { },
            // onImageSettingClick: function () { },
            // onImageSelectClick: function () { },
            // onFileSelectClick: function () { },
            onContentClick: function () { },
            // onPluginsLoaded: function () { },
            coverImageHandler: '',
            customval: '',
            enableModule: false,
            enableAnimation: false,
            colors: ["#ff8f00", "#ef6c00", "#d84315", "#c62828", "#58362f", "#37474f", "#353535",
                "#f9a825", "#9e9d24", "#558b2f", "#ad1457", "#6a1b9a", "#4527a0", "#616161",
                "#00b8c9", "#009666", "#2e7d32", "#0277bd", "#1565c0", "#283593", "#9e9e9e"],
            gradientcolors: [
                ["linear-gradient(0deg, rgb(255, 57, 25), rgb(249, 168, 37))", "light"],
                ["linear-gradient(0deg, rgb(255, 57, 25), rgb(255, 104, 15))", "light"],
                ["linear-gradient(0deg, #FF5722, #FF9800)", "light"],
                ["linear-gradient(0deg, #613ca2, rgb(110, 123, 217))", "light"],
                ["linear-gradient(0deg, rgb(65, 70, 206), rgb(236, 78, 130))", "light"],
                ["linear-gradient(0deg, rgb(0, 150, 102), rgb(90, 103, 197))", "light"],
                ["linear-gradient(30deg, rgb(249, 119, 148), rgb(98, 58, 162))", "light"],
                ["linear-gradient(0deg, rgb(223, 70, 137), rgb(90, 103, 197))", "light"],
                ["linear-gradient(0deg, rgb(40, 53, 147), rgb(90, 103, 197))", "light"],
                ["linear-gradient(0deg, rgb(21, 101, 192), rgb(52, 169, 239))", "light"],
                ["linear-gradient(0deg, rgb(32, 149, 219), rgb(139, 109, 230))", "light"],
                ["linear-gradient(0deg, rgb(90, 103, 197), rgb(0, 184, 201))", "light"],
                ["linear-gradient(0deg, rgb(0, 184, 201), rgb(253, 187, 45))", "light"],
                ["linear-gradient(0deg, rgb(255, 208, 100), rgb(239, 98, 159))", "light"],
                ["linear-gradient(0deg, rgb(0, 214, 223), rgb(130, 162, 253))", "light"],
                ["linear-gradient(0deg, rgb(50, 234, 251), rgb(248, 247, 126))", "dark"],
                ["linear-gradient(0deg, rgb(141, 221, 255), rgb(255, 227, 255))", "dark"],
                ["linear-gradient(0deg, rgb(255, 170, 170), rgb(255, 255, 200))", "dark"],
                ["linear-gradient(0deg, rgb(239, 239, 239), rgb(252, 252, 252))", "dark"]
                ],
            photoselect: '',
            moduleConfig: [],
            useSidebar: true,
            sidebarData: { "buttons": [
			        { "name": "section", "title": out("Sections") },
			        { "name": "snippet", "title": out("Content Blocks") },
			        { "name": "typography", "title": out("Typography") },
                /*
                To add custom panel, add record  with name: "custom1" or "custom2", and specify title, your custom panel file, and icon:

                { "name": "custom1", "title": "Custom Panel", "src": "assets/modules/panel-example.html", "html": "<i class=\"icon ion-android-bicycle\"></i>" },
                { "name": "custom2", "title": "Custom Panel 2", "src": "assets/modules/panel-example.html", "html": "<i class=\"icon ion-android-bicycle\"></i>" }

                Or use custom div (instead of file). In the following example we use div with id=mypanel for our custom panel:

                { "name": "panelname", "title": "Title here", "content": "#mypanel", "html": "<i class=\"icon ion-android-bicycle\"></i>" },

                Then, add a div anywhere in the body:

                <div id="mypanel" class="is-sidebar-content" style="background:#ddd;max-width:500px;">
                ...Sidebar content here...
                </div>
                */
			        {"name": "code", "title": "HTML" }

		        ]
            },
            disableStaticSection: false,
            largerImageHandler: '',
            framework: '',
            cellFormat: '',
            rowFormat: '',
            row: '',
            cols: [],
            colequal: [],
            colsizes: [],
            classReplace: [],
            columnTool: true,
            elementTool: true,
            snippetPathReplace: ['', ''],
            buttons: ['bold', 'italic', 'underline', 'formatting', 'color', 'align', 'textsettings', 'createLink', 'tags', 'more' , '|', 'undo', 'redo'],
            buttonsMore: ['icon', 'image', '|', 'list', 'font', 'formatPara', '|', 'preferences'],
            customTags: [],
            animateModal: false,
            elementAnimate: true,

            elementEditor: true,
            // onAdd: function () { },
            imageQuality: 0.92,
            columnHtmlEditor: true,
            rowHtmlEditor: true,
            rowMoveButtons: true,
            htmlSyntaxHighlighting: true,
            scrollableEditingToolbar: true,
            toolbar: 'top',
            toolbarDisplay: 'auto',
            toolbarAddSnippetButton: false,
            paste: 'html-without-styles',
            builderMode: '',
            rowcolOutline: true,
            elementSelection: true,
            animatedSorting: false,
            dragWithoutHandle: false,
            addButtonPlacement: '',
            snippetCategories: [
                [120, "Basic"],
                [118, "Article"],
                [101, "Headline"],
                [119, "Buttons"],
                [102, "Photos"],
                [103, "Profile"],
                [116, "Contact"],
                [104, "Products"],
                [105, "Features"],
                [106, "Process"],
                [107, "Pricing"],
                [108, "Skills"],
                [109, "Achievements"],
                [110, "Quotes"],
                [111, "Partners"],
                [112, "As Featured On"],
                [113, "Page Not Found"],
                [114, "Coming Soon"],
                [115, "Help, FAQ"]
                ],
            defaultSnippetCategory: 120,
            outlineMode: '',
            elementHighlight: true,
            rowTool: 'right',
            plugins: [],
            mobileSimpleEdit: false,
            clearPreferences: false,
            imageEmbed: true,
            undoRedoStyles: true,
            undoContainerOnly: false,
            /*
            absolutePath: false,
            emailMode: false,
            sidePanel: 'right',
            snippetHandle: true,
            snippetOpen: false,
            snippetPageSliding: false,
            */

            /* Old Version (backward compatible) */
            onAddSectionOpen: function () { },
            contentHtmlStart: '<div class="is-container is-builder container"><div class="row clearfix"><div class="column full">',
            contentHtmlEnd: '</div></div></div>'

        };

        this.settings = {};

        var $element = jQuery(element),
                    element = element;

        var customgradcolors = [];

        var colorpicker;

        this.init = function () {

            this.settings = jQuery.extend({}, defaults, options);

            $element.addClass('is-wrapper');

            if (typeof _snippets_path !== 'undefined') {
                bSideSnippets = true;
            }

            //Extend onRender with built-in plugins
            var old = this.settings.onRender;
            this.settings.onRender = function () {
                old.call(this);

                try {
                    //Run built-in plugin inside the builder
                    setTimeout(function () {
                        skrollr.get().refresh();
                    }, 100);

                } catch (e) { };
            };


            // if (jQuery('#divCb').length == 0) {
            //     jQuery('body').append('<div id="divCb"></div>');
            // }
            if (jQuery('#_cbhtml').length == 0) {
                jQuery('body').append('<div id="_cbhtml"></div>');
            }

            if(this.settings.sideButtons) {
                var sideButtons = this.settings.sideButtons;
            }

            var html_sidebar = '';
            if (this.settings.useSidebar) {

                html_sidebar += '<svg width="0" height="0" style="position:absolute">' +
                        '<defs>' +
                            '<symbol viewBox="0 0 512 512" id="ion-android-add"><path d="M416 277.333H277.333V416h-42.666V277.333H96v-42.666h138.667V96h42.666v138.667H416v42.666z"></path></symbol>' +
                            '<symbol viewBox="0 0 512 512" id="cb-android-list"><path d="M408 64H104c-22.091 0-40 17.908-40 40v304c0 22.092 17.909 40 40 40h304c22.092 0 40-17.908 40-40V104c0-22.092-17.908-40-40-40zM304 368H144v-48h160v48zm64-88H144v-48h224v48zm0-88H144v-48h224v48z"></path></symbol>' +
                            '<symbol viewBox="0 0 512 512" id="ion-code"><path d="M168 392a23.929 23.929 0 0 1-16.971-7.029l-112-112c-9.373-9.373-9.373-24.569 0-33.941l112-112c9.373-9.372 24.568-9.372 33.941 0 9.371 9.372 9.371 24.568 0 33.941L89.941 256l95.029 95.029c9.371 9.373 9.371 24.568 0 33.941A23.925 23.925 0 0 1 168 392zM344 392a23.929 23.929 0 0 0 16.971-7.029l112-112c9.373-9.373 9.373-24.569 0-33.941l-112-112c-9.373-9.372-24.568-9.372-33.941 0-9.371 9.372-9.371 24.568 0 33.941L422.059 256l-95.029 95.029c-9.371 9.373-9.371 24.568 0 33.941A23.925 23.925 0 0 0 344 392z"></path></symbol>' +
                            '<symbol viewBox="0 0 512 512" id="ion-edit"><path d="M163 439.573l-90.569-90.569L322.78 98.656l90.57 90.569zM471.723 88.393l-48.115-48.114c-11.723-11.724-31.558-10.896-44.304 1.85l-45.202 45.203 90.569 90.568 45.202-45.202c12.743-12.746 13.572-32.582 1.85-44.305zM64.021 363.252L32 480l116.737-32.021z"></path></symbol>' +
                            '<symbol viewBox="0 0 512 512" id="ion-ios-browsers-outline"><path d="M64 144v304h303.9V144H64zm287.9 288H80V160h271.9v272z"></path><path d="M448 64H144v64h16V80h272v272h-48v16h64z"></path></symbol>' +
                            '<symbol viewBox="0 0 2048.0 2048.0" id="icon-snippets"><g id="document" transform="matrix(1,0,0,1,1024.0,1024.0)">			<path d="M-727.581,329.502 L318.058,329.502 L318.058,-527.853 L-727.581,-527.853 L-727.581,329.502 Z " fill="#ffffff" fill-opacity="1.00" stroke-width="85.63" stroke="#000000" stroke-linecap="square" stroke-linejoin="miter" />			<path d="M-347.749,652.594 L697.89,652.594 L697.89,-204.761 L-347.749,-204.761 L-347.749,652.594 Z " fill="#ffffff" fill-opacity="1.00" stroke-width="85.63" stroke="#000000" stroke-linecap="square" stroke-linejoin="miter" />		</g></symbol>' +
                            '' +
                        '</defs>' +
                    '</svg>';
                html_sidebar += '<div class="is-sidebar"  style="transform: translate3d(0,0,0);display: flex;flex-direction: column;">';

                var enableContentStyle = this.settings.enableContentStyle;
                var htmlSyntaxHighlighting = this.settings.htmlSyntaxHighlighting;
                var sideIndex = 0;
                $.each(this.settings.sidebarData.buttons, function () {
                    if (this.name == 'section') {
                        html_sidebar += '<div class="is-sidebar-button" data-content="divSidebarSections" data-command="section" data-title="' + this.title + '" title="' + this.title + '">' +
                            '<svg class="svg-icon"><use xlink:href="#ion-android-add"></use></svg>' +
                            '</div>';
                    }
                    else if (this.name == 'snippet') {
                        if (bSideSnippets) {
                            html_sidebar += '<div class="is-sidebar-button" data-content="divSidebarSnippets" data-title="' + this.title + '" title="' + this.title + '">' +
                            '<svg class="svg-icon"><use xlink:href="#icon-snippets"></use></svg>' +
                            '</div>';
                        }
                    }
                    else if (this.name == 'typography') {
                        if (enableContentStyle) {
                            html_sidebar += '<div class="is-sidebar-button" data-content="divSidebarTypography" data-command="typography" data-title="' + this.title + '" title="' + this.title + '">' +
                            '<span style="font-family:serif;font-size:21px;display: inline-block;position:absolute;left:0;width:50px;">a</span>' +
                            '</div>';
                        }
                    }
                    else if (this.name == 'code') {
                        if(htmlSyntaxHighlighting) {
                            html_sidebar += '<div class="is-sidebar-button" data-command="code" data-title="' + this.title + '" title="' + this.title + '">' +
                                '<svg class="svg-icon" style="width:13px;height:13px;"><use xlink:href="#ion-code"></use></svg>' +
                                '</div>';
                        } else {
                            html_sidebar += '<div class="is-sidebar-button" data-content="divSidebarSource" data-command="code" data-title="' + this.title + '" title="' + this.title + '">' +
                                '<svg class="svg-icon" style="width:13px;height:13px;"><use xlink:href="#ion-code"></use></svg>' +
                                '</div>';
                        }
                    }
                    else if (this.name == 'custom1') {
                        html_sidebar += '<div class="is-sidebar-button" data-content="divCustomSidebarArea1" data-title="' + this.title + '" title="' + this.title + '" data-src="' + this.src + '">' + this.html + '</div>';
                    }
                    else if (this.name == 'custom2') {
                        html_sidebar += '<div class="is-sidebar-button" data-content="divCustomSidebarArea2" data-title="' + this.title + '" title="' + this.title + '" data-src="' + this.src + '">' + this.html + '</div>';
                    }
                    else {
                        //custom buttons
                        html_sidebar += '<div class="is-sidebar-button" data-content="' + this.content.substr(1) + '" data-title="' + this.title + '" title="' + this.title + '">' + this.html + '</div>';
                    }

                    if(sideButtons) {
                        /*
                        Alternative way to add sidebar button:

                        $(".is-wrapper").contentbox({
                            sideButtons:[{
                                    'pos': 0,
                                    'title': 'Writing Set',
                                    'src': 'assets/modules/panel-example.html',
                                    'html': '<svg class="svg-icon"><use xlink:href="#ion-edit"></use></svg>',
                                    'class': 'sidebar-sections'
                                }
                            ]
                        });
                        */

                        $.each(sideButtons, function () {
                            var btn = this;

                            if(sideIndex==btn.pos){
                                var panelId = makeid();
                                html_sidebar += '<div class="is-sidebar-button" data-content="' + panelId + '" data-src="' + btn.src + '" data-title="' + out(btn.title) + '" title="' + out(btn.title) + '">' +
                                    btn.html +
                                '</div>';

                                var panelHtml =
                                '<div id="' + panelId + '" class="is-sidebar-content ' + btn.class + '" style="-webkit-transition-duration:0.2s;transition-duration:0.2s;">' +
                                    '<div>' +
                                        '<iframe src="about:blank" style="width:100%;height:100%;box-sizing:border-box;border:none;">' +
                                        '</iframe>' +
                                    '</div>' +
                                '</div>';
                                jQuery('#_cbhtml').append(panelHtml);

                            }

                        });
                    }

                    sideIndex++;
                });

                /* If you want to add custom button on the sidebar's bottom area:
                html_sidebar += '<div style="position:absolute;left:0;bottom:0;height:auto;display:inline-block;width:50px;">' +
                '<div class="is-sidebar-button">' +
                '<svg class="svg-icon ion-code"><use xlink:href="#ion-code"></use></svg>' +
                '</div>' +
                '<div class="is-sidebar-button">' +
                '<svg class="svg-icon ion-code"><use xlink:href="#ion-code"></use></svg>' +
                '</div>' +
                '</div>';
                */

                html_sidebar += '</div>';

                html_sidebar += '' +
                    '<div id="divSidebarSections" class="is-sidebar-content" style="-webkit-transition-duration:0.2s;transition-duration:0.2s;">' +
	                    '<div>' +
                            '<iframe id="ifrIdeasPanel" src="about:blank" style="width:100%;height:100%;box-sizing:border-box;border:none;">' +
                            '</iframe>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divSidebarSnippets" class="is-sidebar-content" style="max-width:268px;border-left: transparent 50px solid;box-sizing: border-box;">' +
	                    '' +
                    '</div>' +
                    '<div id="divSidebarSource" class="is-sidebar-content" style="-webkit-transition-duration:0.2s;transition-duration:0.2s;">' +
	                    '<div>' +
					        '<div style="position:absolute;width:240px;height:35px;right:10px;top:7px;z-index:1;">' +
                                '<button title="' + out('Cancel') + '" id="btnViewHtmlCancel" class="secondary"> ' + out('Cancel') + ' </button>' +
                                '<button title="' + out('Ok') + '" id="btnViewHtmlOk" class="primary"> ' + out('Ok') + ' </button>' +
                            '</div>' +
                            '<div style="height:100%;box-sizing:border-box;border-top:#f3f3f3 50px solid;position:relative">' +
                                '<textarea id="inpViewHtml" style="width:100%;height:100%;resize: none;"></textarea>' +
                                '<button title="' + out('Enlarge') + '" class="edit-html-larger" style="width:40px;height:40px;position:absolute;right:20px;top:0;background:#fff;padding: 0;"><svg class="is-icon-flex" style="width:22px;height:22px;fill:rgb(170, 170, 170);"><use xlink:href="#ion-arrow-expand"></use></svg></button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divSidebarTypography" class="is-sidebar-content" style="-webkit-transition-duration:0.2s;transition-duration:0.2s;">' +
	                    '<div>' +
                            '<iframe id="ifrTypographyPanel" src="about:blank" style="width:100%;height:100%;box-sizing:border-box;border:none;">' +
                            '</iframe>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divCustomSidebarArea1" class="is-sidebar-content" style="max-width:500px;">' +
	                    '<div style="padding:0 0 0 50px;box-sizing:border-box;">' +
                            '<iframe id="ifrCustomSidebarArea1" src="about:blank" style="width:100%;height:100%;box-sizing:border-box;border:none;">' +
                            '</iframe>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divCustomSidebarArea2" class="is-sidebar-content" style="max-width:500px;">' +
	                    '<div style="padding:0 0 0 50px;box-sizing:border-box;">' +
                            '<iframe id="ifrCustomSidebarArea2" src="about:blank" style="width:100%;height:100%;box-sizing:border-box;border:none;">' +
                            '</iframe>' +
                        '</div>' +
                    '</div>';

                jQuery('#_cbhtml').append(html_sidebar);

            } else {

                var html_normal = '<div id="divSections" style="display:none"></div>' +
                    '<div class="is-modal addsection">' +
                        '<div style="max-width: 900px;">' +
                            '<div id="divSectionList" class="is-section-list"></div>' +
                        '</div>' +
                    '</div>';

                jQuery('#_cbhtml').append(html_normal);
            }

            _fb = new ContentBuilder({
                container: '.is-container',
                page: '.is-wrapper',
                snippetPath: _snippets_path,
                snippetJSON: data_basic,
                onChange: this.settings.onChange,
                onRender: this.settings.onRender,
                moduleConfig: this.settings.moduleConfig,
                modulePath: this.settings.modulePath,
                onImageSelectClick: this.settings.onImageSelectClick,
                onFileSelectClick: this.settings.onFileSelectClick,
                onImageBrowseClick: this.settings.onImageBrowseClick,
                onImageSettingClick: this.settings.onImageSettingClick,
                onContentClick: this.settings.onContentClick,
                onPluginsLoaded: this.settings.onPluginsLoaded,
                imageselect: this.settings.imageselect,
                fileselect: this.settings.fileselect,
                imageEmbed: this.settings.imageEmbed,
                sourceEditor: this.settings.sourceEditor,
                customval: this.settings.customval,
                snippetData: this.settings.snippetData,
                colors: this.settings.colors,
                gradientcolors: this.settings.gradientcolors,
                buttons: this.settings.buttons,
                buttonsMore: this.settings.buttonsMore,
                customTags: this.settings.customTags,
                largerImageHandler: this.settings.largerImageHandler,
                framework: this.settings.framework,
                cellFormat: this.settings.cellFormat,
                rowFormat: this.settings.rowFormat,
                row: this.settings.row,
                cols: this.settings.cols,
                colequal: this.settings.colequal,
                colsizes: this.settings.colsizes,
                classReplace: this.settings.classReplace,
                columnTool: this.settings.columnTool,
                elementTool: this.settings.elementTool,
                snippetPathReplace: this.settings.snippetPathReplace,
                animateModal: this.settings.animateModal,
                elementAnimate: this.settings.elementAnimate,
                snippetList: '#divSidebarSnippets',

                elementEditor: this.settings.elementEditor,
                onAdd: this.settings.onAdd,
                imageQuality: this.settings.imageQuality,
                columnHtmlEditor: this.settings.columnHtmlEditor,
                rowHtmlEditor: this.settings.rowHtmlEditor,
                rowMoveButtons: this.settings.rowMoveButtons,
                htmlSyntaxHighlighting: this.settings.htmlSyntaxHighlighting,
                scrollableEditingToolbar: this.settings.scrollableEditingToolbar,
                toolbar: this.settings.toolbar,
                toolbarDisplay: this.settings.toolbarDisplay,
                toolbarAddSnippetButton: this.settings.toolbarAddSnippetButton,
                paste: this.settings.paste,
                builderMode: this.settings.builderMode,
                rowcolOutline: this.settings.rowcolOutline,
                elementSelection: this.settings.elementSelection,
                animatedSorting: this.settings.animatedSorting,
                dragWithoutHandle: this.settings.dragWithoutHandle,
                addButtonPlacement: this.settings.addButtonPlacement,
                outlineMode: this.settings.outlineMode,
                elementHighlight: this.settings.elementHighlight,
                rowTool: this.settings.rowTool,
                plugins: this.settings.plugins,
                mobileSimpleEdit: this.settings.mobileSimpleEdit,
                clearPreferences: this.settings.clearPreferences,

                snippetCategories: this.settings.snippetCategories,
                defaultSnippetCategory: this.settings.defaultSnippetCategory,

                scriptPath: this.settings.scriptPath,
                assetPath: this.settings.assetPath,
                pluginPath: this.settings.pluginPath,
                fontAssetPath: this.settings.fontAssetPath,

                undoRedoStyles: this.settings.undoRedoStyles,
                onUndo: function() {
                    $element.data("contentbox").setup();
                },
                onRedo: function() {
                    $element.data("contentbox").setup();
                },
                undoContainerOnly: this.settings.undoContainerOnly,
            });

            var s = '' +
            '<div class="is-modal delsectionconfirm">' +
                '<div style="max-width: 400px;">' +
                    '<p style="margin-bottom: 25px;text-align:center;">' + out('Are you sure you want to delete this section?') + '</p>' +
                    '<button title="' + out('Delete') + '" class="input-ok classic">' + out('Delete') + '</button>' +
                '</div>' +
            '</div>' +
            '' +
            '<div class="is-modal editsection">' +
                '<div style="max-width: 242px;padding:0;">' +
                    '<div class="is-modal-bar is-draggable">' + out('Section Settings') + '</div>' +
                    '<div style="padding:20px;">' +
                        '<div class="is-settings">' +
                            '<div>' + out('Move Section') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Move Up') + '" class="cmd-section-up" style="font-size:17px;">&#8593;</button>' +
                                '<button title="' + out('Move Down') + '" class="cmd-section-down" style="border-left:none;font-size:17px;">&#8595;</button>' +
                                '<button title="' + out('Move to Top') + '" class="cmd-section-top" style="border-left:none;"><span style="font-size:20px;transform:rotate(90deg);position:absolute;top:13px;left:15px;">&#8676;</span></button>' +
                                '<button title="' + out('Move to Bottom') + '" class="cmd-section-bottom" style="border-left:none;"><span style="font-size:20px;transform:rotate(90deg);position:absolute;top:13px;left:15px;">&#8677;</span></button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings">' +
                            '<div>' + out('Height') + ':</div>' +
                            '<div>' +
                                '<button class="cmd-section-height" data-value="0">Auto</button>' +
                                '<button class="cmd-section-height" data-value="20" style="border-left:none;">20%</button>' +
                                '<button class="cmd-section-height" data-value="30" style="border-left:none;">30%</button>' +
                                '<button class="cmd-section-height" data-value="40" style="border-left:none;">40%</button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                            '<div>' +
                                '<button class="cmd-section-height" data-value="50" style="border-top:none;">50%</button>' +
                                '<button class="cmd-section-height" data-value="60" style="border-left:none;border-top:none;">60%</button>' +
                                '<button class="cmd-section-height" data-value="75" style="border-left:none;border-top:none;">75%</button>' +
                                '<button class="cmd-section-height" data-value="100" style="border-left:none;border-top:none;">100%</button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings" style="margin-bottom:0">' +
                            '<div>' +
                                '<label for="chkScrollIcon" style="margin:0;"><input id="chkScrollIcon" type="checkbox" /> ' + out('Scroll Icon') + '</label>' +
                            '</div>' +
                            '<div>' +
                                '<button title="' + out('Light') + '" class="cmd-section-scroll" data-value="light">' + out('Light') + '</button>' +
                                '<button title="' + out('Dark') + '" class="cmd-section-scroll" data-value="dark" style="border-left:none;">' + out('Dark') + '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '' +
            '<div class="is-modal editmodule">' +
                '<div style="max-width:900px;height:570px;padding:0;box-sizing:border-box;position:relative;">' +
                    '<div class="is-modal-bar is-draggable" style="position: absolute;top: 0;left: 0;width: 100%;z-index:1;">' + out('Module Settings') + '</div>' +
                    '<iframe style="position: absolute;top: 0;left: 0;width:100%;height:100%;border:none;border-bottom:60px solid transparent;border-top:40px solid transparent;margin:0;box-sizing:border-box;" src="about:blank"></iframe>' +
                    '<input id="hidModuleCode" type="hidden" />' +
                    '<input id="hidModuleSettings" type="hidden" />' +
                    '<button class="input-ok classic" style="height:60px;position:absolute;left:0;bottom:0;">' + out('Ok') + '</button>' +
                '</div>' +
            '</div>' +
            '' +
            '<div class="is-modal editcustomcode">' +
                '<div style="max-width:900px;height:570px;padding:0;box-sizing:border-box;position:relative;">' +
                    '<div class="is-modal-bar is-draggable" style="position: absolute;top: 0;left: 0;width: 100%;z-index:1;">' + out('Custom Code (Javascript Allowed)') + '</div>' +
                    '<textarea id="txtBoxCustomCode" class="inptxt" style="background: #fff;position: absolute;top: 0;left: 0;width:100%;height:100%;border:none;border-bottom:60px solid transparent;border-top:40px solid transparent;box-sizing:border-box;"></textarea>' +
                    '<input id="hidBoxCustomCode" type="hidden" />' +
                    '<button class="cell-html-larger" style="width:35px;height:35px;position:absolute;right:0;top:0;background:transparent;z-index:2;"><svg class="is-icon-flex" style="width:19px;height:19px;fill:rgb(170, 170, 170);"><use xlink:href="#ion-arrow-expand"></use></svg></button>' +
                    '<button class="input-ok classic" style="height:60px;position:absolute;left:0;bottom:0;">' + out('Ok') + '</button>' +
                '</div>' +
            '</div>' +
            '' +
            '<div class="is-modal editbox">' +
                '<div style="max-width:293px;padding:0">' +
                    '<div class="is-modal-bar is-draggable">' + out('Box Settings') + '</div>' +
                    '<div class="is-tabs clearfix">' +
                        '<a id="tabBoxGeneral" href="" data-content="divBoxGeneral" class="active">' + out('General') + '</a>' +
                        '<a id="tabBoxContentContainer" href="" data-content="divBoxContentContainer">' + out('Content') + '</a>' +
                        '<a id="tabBoxContentText" href="" data-content="divBoxContentText">' + out('Text') + '</a>' +
                        '<a id="tabBoxImage" href="" data-content="divBoxImage">' + out('Image') + '</a>' +
                        '<a id="tabBoxModule" href="" data-content="divBoxPlaceModule">' + out('Module') + '</a>' +
                        '<a id="tabBoxAnimate" href="" data-content="divBoxAnimate">' + out('Animate') + '</a>' +
                        '<a id="tabBoxCustomHtml" href="" data-content="divBoxCustomHtml" style="display:none">' + out('HTML') + '</a>' +
                    '</div>' +

                    '<div id="divBoxGeneral" class="is-tab-content" data-group="boxsettings" style="display:block">' +
                        '<div id="divBoxSize" class="is-settings">' +
                            '<div>' + out('Box Size') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Decrease') + '" class="cmd-box-smaller">-</button>' +
                                '<button title="' + out('Increase') + '" class="cmd-box-larger" style="border-left:none">+</button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        '<div id="divContentSize" class="is-settings">' +
                            '<div>' + out('Content Size') + ':</div>' +
                            '<div style="display: flex;flex-direction: row;flex-wrap: wrap;height:90px;">' +
                                '<input class="inp-box-size" type="text" style="width:100px;height:45px;text-align:center;font-size:12px;" />' +
                                '<button class="cmd-box-size" data-value="380" style="width:50px;border-left:none">380</button>' +
                                '<button class="cmd-box-size" data-value="500" style="width:50px;border-left:none">500</button>' +
                                '<button class="cmd-box-size" data-value="640" style="width:50px;border-left:none">640</button>' +
                                '<button class="cmd-box-size" data-value="800" style="width:50px;border-top:none">800</button>' +
                                '<button class="cmd-box-size" data-value="1100" style="width:50px;border-top:none;border-left:none">1100</button>' +
                                '<button class="cmd-box-size" data-value="1400" style="width:50px;border-top:none;border-left:none">1400</button>' +
                                '<button title="' + out('Decrease') + '" class="cmd-box-size" data-value="-" style="width:50px;border-top:none;border-left:none">-</button>' +
                                '<button title="' + out('Increase') + '"class="cmd-box-size" data-value="+" style="width:50px;border-top:none;border-left:none">+</button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        '<div id="divBoxBackgroundColor" class="is-settings clearfix" style="margin-bottom:2px;">' +
                            '<div>' + out('Background Color') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Light') + '" class="cmd-box-bgcolor" data-value="light"></button>' + /*<span style="font-family:serif;font-size:19px;margin-top:0px;display:inline-block;">A</span>*/
                                '<button title="' + out('Grey') + '"class="cmd-box-bgcolor" data-value="grey" style="border-left:none;background:#eee;"></button>' + /*<span style="font-family:serif;font-size:19px;margin-top:0px;display:inline-block;">A</span>*/
                                '<button title="' + out('Dark') + '"class="cmd-box-bgcolor" data-value="dark" style="border:transparent 1px solid;background:#333;color:#fff"></button>' + /*<span style="font-family:serif;font-size:19px;margin-top:0px;display:inline-block;">A</span>*/
                                '<input type="hidden" id="inpBoxBgColor" value=""/>' +
                                '<button class="cmd-box-pickbgcolor" data-value="dark" style="border-left:none;"><span style="display:block;margin-top:-2px;">&#9681;</span></button>' +
                                '<button title="' + out('Clear') + '" class="cmd-box-bgcolor" style="border-left:none;" data-value="">&#10005;</button>' +
                                '<br style="clear:both">' +
                                '<button title="' + out('Gradient') + '" class="cmd-box-gradient" data-value="+" style="width:100%;font-size: 14px;margin-top:20px;"> ' + out('Gradient') + ' </button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        '<div id="divBoxPickPhoto" class="is-settings" style="margin-bottom:0;">' +
                            '<button class="cmd-box-pickphoto" data-value="" style="width:100%"><svg class="is-icon-flex" style=""><use xlink:href="#ion-image"></use></svg></button>' +
                            '<br style="clear:both">' +
                        '</div>' +
                        '<p id="divNoBoxSettings" style="text-align: center;display:none;">' + out('This box has no available settings.') + '</p>' +
                    '</div>' +
                    '<div id="divBoxContentText" class="is-tab-content" data-group="boxsettings">' +
                        '<div class="is-settings" style="display:inline-block;width:100px;margin-right:12px;margin-bottom:0">' +
                            '<div>' + out('Text Style') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Light') + '" class="cmd-box-textcolor" data-value="light">' + out('Light') + '</button>' +
                                '<button title="' + out('Dark') + '" class="cmd-box-textcolor" data-value="dark" style="border-left:none;">' + out('Dark') + '</button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings" style="display:inline-block;width:150px;margin-bottom:0">' +
                            '<div>' + out('Transparency') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Increase') + '" class="cmd-box-textopacity" data-value="+"> + </button>' +
                                '<button title="' + out('Decrease') + '" class="cmd-box-textopacity" data-value="-" style="border-left:none;"> - </button>' +
                                '<button title="' + out('Not Set') + '" class="cmd-box-textopacity" data-value="" style="border-left:none;">' + out('Not Set') + '</button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings">' +
                            '<div>Align:</div>' +
                            '<div>' +
                                '<button title="' + out('Align Left') + '" class="cmd-box-textalign" data-value="left"><svg class="is-icon-flex" style="fill:rgba(0, 0, 0, 0.8);margin-top:3px;width:14px;height:14px;"><use xlink:href="#icon-align-left"></use></svg></button>' +
                                '<button title="' + out('Align Center') + '" class="cmd-box-textalign" data-value="center" style="border-left:none;"><svg class="is-icon-flex" style="fill:rgba(0, 0, 0, 0.8);margin-top:3px;width:14px;height:14px;"><use xlink:href="#icon-align-center"></use></svg></button>' +
                                '<button title="' + out('Align Right') + '" class="cmd-box-textalign" data-value="right" style="border-left:none;"><svg class="is-icon-flex" style="fill:rgba(0, 0, 0, 0.8);margin-top:3px;width:14px;height:14px;"><use xlink:href="#icon-align-right"></use></svg></button>' +
                                '<button title="' + out('Align Full') + '" class="cmd-box-textalign" data-value="justify" style="border-left:none;"><svg class="is-icon-flex" style="fill:rgba(0, 0, 0, 0.8);margin-top:3px;width:14px;height:14px;"><use xlink:href="#icon-align-full"></use></svg></button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                        (this.settings.enableContentStyle ?
                            '<div class="is-settings" style="margin-bottom:0">' +
                                '<div>' + out('Typography') + ':</div>' +
                                '<div>' +
                                    '<button title="' + out('Change Style') + '" class="cmd-box-typography" data-value="+" style="width:100%;font-size: 14px;"> ' + out('Change Style') + ' </button>' +
                                    '<br style="clear:both">' +
                                '</div>' +
                            '</div>' : '') +
                    '</div>' +
                    '<div id="divBoxContentContainer" class="is-tab-content" data-group="boxsettings">' +
            /*
            '<div class="is-settings">' +
            '<div>Content Size:</div>' +
            '<div>' +
            '<button class="cmd-box-size" data-value="380" style="width:50px">380px</button>' +
            '<button class="cmd-box-size" data-value="500" style="width:50px;border-left:none">500px</button>' +
            '<button class="cmd-box-size" data-value="800" style="width:50px;border-left:none">800px</button>' +
            '<button class="cmd-box-size" data-value="-" style="width:50px;border-left:none">-</button>' +
            '<button class="cmd-box-size" data-value="+" style="width:50px;border-left:none">+</button>' +
            '<br style="clear:both">' +
            '</div>' +
            '</div>' +
            */
                        '<div class="is-settings">' +
                            '<div>' + out('Position') + ':</div>' +
                            '<div style="margin-bottom:0">' +
                                '<button title="' + out('Top Left') + '" class="cmd-box-content-pos" data-value="topleft">&#8598;</button>' +
                                '<button title="' + out('Top Center') + '" class="cmd-box-content-pos" data-value="topcenter" style="border-left:none;">&#8593;</button>' +
                                '<button title="' + out('Top Right') + '" class="cmd-box-content-pos" data-value="topright" style="border-left:none;">&#8599;</button>' +
                            '</div>' +
                            '<div style="margin-bottom:0">' +
                                '<button title="' + out('Middle Left') + '" class="cmd-box-content-pos" data-value="middleleft" style="border-top:none;">&#8592;</button>' +
                                '<button title="' + out('Middle Center') + '" class="cmd-box-content-pos" data-value="middlecenter" style="border-left:none;border-top:none;">&#9737;</button>' +
                                '<button title="' + out('Middle Right') + '" class="cmd-box-content-pos" data-value="middleright" style="border-left:none;border-top:none;">&#8594;</button>' +
                            '</div>' +
                            '<div>' +
                                '<button title="' + out('Bottom Left') + '" class="cmd-box-content-pos" data-value="bottomleft" style="border-top:none;">&#8601;</button>' +
                                '<button title="' + out('Bottom Center') + '" class="cmd-box-content-pos" data-value="bottomcenter" style="border-left:none;border-top:none;">&#8595;</button>' +
                                '<button title="' + out('Bottom Right') + '" class="cmd-box-content-pos" data-value="bottomright" style="border-left:none;border-top:none;">&#8600;</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings">' +
                            '<div>' + out('Top/Bottom Adjustment') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Decrease') + '" class="cmd-box-content-edge-y" data-value="-">-</button>' +
                                '<button title="' + out('Increase') + '" class="cmd-box-content-edge-y" data-value="+" style="border-left:none;">+</button>' +
                                '<button title="' + out('Not Set') + '" class="cmd-box-content-edge-y" data-value="" style="border-left:none;">' + out('Not Set') + '</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings" style="margin-bottom:0">' +
                            '<div>' + out('Left/Right Adjustment') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Decrease') + '" class="cmd-box-content-edge-x" data-value="-">-</button>' +
                                '<button title="' + out('Increase') + '" class="cmd-box-content-edge-x" data-value="+" style="border-left:none;">+</button>' +
                                '<button title="' + out('Not Set') + '" class="cmd-box-content-edge-x" data-value="" style="border-left:none;">' + out('Not Set') + '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divBoxImage" class="is-tab-content" data-group="boxsettings">' +

						(this.settings.onCoverImageSelectClick != null
						?
                        '<div class="is-settings" style="width:120px;display:inline-block;margin-right:12px;float:left;margin-bottom:0;">' +
                            '<div>' +
                                '<button class="cmd-box-selectasset" style="width:120px;">' + out('Select Image') + '"</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings" style="width:120px;display:inline-block;margin-bottom:0;">' +
                            '<div>' +
                                '<label for="chkAnimateBg" style="margin:0;line-height:50px"><input id="chkAnimateBg" type="checkbox" /> ' + out('Ken Burns') + '</label>' +
                            '</div>' +
                        '</div>'
						:
                        '<div class="is-settings" style="margin-bottom:0;">' +
                            '<div>' +
                                '<label for="chkAnimateBg" style="margin:0;"><input id="chkAnimateBg" type="checkbox" /> ' + out('Ken Burns Effect') + '</label>' +
                            '</div>' +
                        '</div>'
						) +

                        '<div class="is-settings" style="margin-bottom:0;width:100%;">' +
                            '<div>' +
                                '<label for="chkParallaxBg" style="margin:0;"><input id="chkParallaxBg" type="checkbox" /> ' + out('Parallax') + '</label>' +
                            '</div>' +
                        '</div>' +

                        '<div class="is-settings">' +
                            '<div>' + out('Overlay Color') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('White') + '" class="cmd-box-overlaycolor" data-value="#ffffff">White</button>' +
                                '<button title="' + out('Black') + '" class="cmd-box-overlaycolor" data-value="#000000" style="border-left:none;">Black</button>' +
                                '<button class="cmd-box-pickoverlaycolor" style="border-left:none;"><span style="display:block;margin-top:-2px;">&#9681;</span></button>' +
                                '<button title="' + out('None') + '" class="cmd-box-overlaycolor" data-value="" style="border-left:none;">' + out('None') + '</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings">' +
                            '<div>' + out('Overlay Transparency') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Increase') + '" class="cmd-box-overlayopacity" data-value="+">+</button>' +
                                '<button title="' + out('Decrease') + '" class="cmd-box-overlayopacity" data-value="-" style="border-left:none;">-</button>' +
                                '<button title="' + out('None') + '" class="cmd-box-overlayopacity" data-value="0" style="border-left:none;">' + out('None') + '</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings">' +
                            '<div>' + out('Horizontal Position') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Left') + '" class="cmd-bg-img-x" data-value="-">&#8592;</button>' +
                                '<button title="' + out('Right') + '" class="cmd-bg-img-x" data-value="+" style="border-left:none;">&#8594;</button>' +
                                '<button title="' + out('Default') + '" class="cmd-bg-img-x" data-value="" style="width:60px;border-left:none;">' + out('Default') + '</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings" style="margin-bottom:0">' +
                            '<div>' + out('Vertical Position') + ':</div>' +
                            '<div>' +
                                '<button title="' + out('Top') + '" class="cmd-bg-img-y" data-value="-">&#8595;</button>' +
                                '<button title="' + out('Bottom') + '" class="cmd-bg-img-y" data-value="+" style="border-left:none;">&#8593;</button>' +
                                '<button title="' + out('Default') + '" class="cmd-bg-img-y" data-value="" style="width:60px;border-left:none;">' + out('Default') + '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divBoxPlaceModule" class="is-tab-content" data-group="boxsettings">' +
                        '<div class="is-settings" style="margin-bottom:0">' +
                            '<div>' +
                                '<label for="chkBgModule" style="margin:0;"><input id="chkBgModule" type="checkbox" /> ' + out('Module Placement') + '</label>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divBoxAnimate" class="is-tab-content" data-group="boxsettings">' +
                        '<div class="is-settings">' +
                            '<div class="clearfix">' +
                                '<select class="cmd-box-animate" style="margin-right:12px;float:left">' +
                                    '<option value="">' + out('None') + '</option>' +
                                    '<option value="is-pulse">pulse</option>' +
                                    '<option value="is-bounceIn">bounceIn</option>' +
                                    '<option value="is-fadeIn">fadeIn</option>' +
                                    '<option value="is-fadeInDown">fadeInDown</option>' +
                                    '<option value="is-fadeInLeft">fadeInLeft</option>' +
                                    '<option value="is-fadeInRight">fadeInRight</option>' +
                                    '<option value="is-fadeInUp">fadeInUp</option>' +
                                    '<option value="is-flipInX">flipInX</option>' +
                                    '<option value="is-flipInY">flipInY</option>' +
                                    '<option value="is-slideInUp">slideInUp</option>' +
                                    '<option value="is-slideInDown">slideInDown</option>' +
                                    '<option value="is-slideInLeft">slideInLeft</option>' +
                                    '<option value="is-slideInRight">slideInRight</option>' +
                                    '<option value="is-zoomIn">zoomIn</option>' +
                                '</select>' +
                                '<label for="chkAnimOnce" style="margin:10px 0 0;"><input id="chkAnimOnce" type="checkbox" /> ' + out('Once') + '</label>' +
                                '<br style="clear:both"/>' +
                                '<label class="clearfix" style="margin:10px 0 0;display:block">' + out('Delay') + ': <select class="cmd-box-animatedelay" style="margin-right:12px;">' +
                                    '<option value="">' + out('None') + '</option>' +
                                    '<option value="delay-0ms">0s</option>' +
                                    '<option value="delay-100ms">100ms</option>' +
                                    '<option value="delay-200ms">200ms</option>' +
                                    '<option value="delay-300ms">300ms</option>' +
                                    '<option value="delay-400ms">400ms</option>' +
                                    '<option value="delay-500ms">500ms</option>' +
                                    '<option value="delay-600ms">600ms</option>' +
                                    '<option value="delay-700ms">700ms</option>' +
                                    '<option value="delay-800ms">800ms</option>' +
                                    '<option value="delay-900ms">900ms</option>' +
                                    '<option value="delay-1000ms">1000ms</option>' +
                                    '<option value="delay-1100ms">1100ms</option>' +
                                    '<option value="delay-1200ms">1200ms</option>' +
                                    '<option value="delay-1300ms">1300ms</option>' +
                                    '<option value="delay-1400ms">1400ms</option>' +
                                    '<option value="delay-1500ms">1500ms</option>' +
                                    '<option value="delay-1600ms">1600ms</option>' +
                                    '<option value="delay-1700ms">1700ms</option>' +
                                    '<option value="delay-1800ms">1800ms</option>' +
                                    '<option value="delay-1900ms">1900ms</option>' +
                                    '<option value="delay-2000ms">2000ms</option>' +
                                    '<option value="delay-2100ms">2100ms</option>' +
                                    '<option value="delay-2200ms">2200ms</option>' +
                                    '<option value="delay-2300ms">2300ms</option>' +
                                    '<option value="delay-2400ms">2400ms</option>' +
                                    '<option value="delay-2500ms">2500ms</option>' +
                                    '<option value="delay-2600ms">2600ms</option>' +
                                    '<option value="delay-2700ms">2700ms</option>' +
                                    '<option value="delay-2800ms">2800ms</option>' +
                                    '<option value="delay-2900ms">2900ms</option>' +
                                    '<option value="delay-3000ms">3000ms</option>' +
                                '</select></label>' +
                            '</div>' +
                        '</div>' +
                        '<div class="is-settings" style="margin-bottom:0">' +
                            '<div>' +
                                '<button class="cmd-box-animate-test" style="width:100%">' + out('Test') + '</button>' +
                                '<br style="clear:both">' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div id="divBoxCustomHtml" class="is-tab-content" data-group="boxsettings">' +
                        '<div class="is-settings" style="margin-bottom:0">' +
                            '<div>' +
                                '<textarea id="inpBoxHtml" style="width:100%;height:220px;min-height:200px;border:#eee 1px solid;"></textarea>' +
                                '<button class="cmd-box-html">' + out('Apply') + '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '' +
            '<div class="is-modal pickphoto">' +
                '<div style="max-width:1000px;height:570px;padding:0;box-sizing:border-box;position:relative;">' +
                    '<div class="is-modal-bar is-draggable" style="position: absolute;top: 0;left: 0;width: 100%;z-index:1;">' + out('Photos') + '</div>' +
                    '<iframe style="position: absolute;top: 0;left: 0;width:100%;height:100%;border:none;border-top:40px solid transparent;margin:0;box-sizing:border-box;" src="about:blank"></iframe>' +
                '</div>' +
            '</div>' +
            '' +
            '<div class="is-modal applytypography">' +
                '<div style="max-width: 400px;text-align:center;">' +
                    '<p>' + out('This page has one or more sections that have their own typography style.') + '</p>' +
                    '<label><input name="rdoApplyTypoStyle" type="radio" value="1">' + out('Replace all sections\' typography style.') + '</label><br>' +
                    '<label><input name="rdoApplyTypoStyle" type="radio" value="0">' + out('Keep sections\' specific typography style.') + '</label>' +
                    '<p style="font-size:1rem"><i>' + out('To apply typography style on a specific section, goto \'Content Style\' tab in Box Settings') + '</i></p>' +
                    '<button class="input-ok classic">' + out('Ok') + '</button>' +
                '</div>' +
            '</div>' +
            '';

            jQuery('#_cbhtml').append(s);

            if (this.settings.useSidebar) {

                jQuery('body').addClass('sidebar-active');

                jQuery('.is-sidebar > div').on('click', function () {

                    if (jQuery(this).hasClass('active')) { // toggle
                        jQuery('.is-sidebar-overlay').remove();
                        jQuery('.is-sidebar > div').removeClass('active');
                        jQuery('.is-sidebar-content').removeClass('active');
                        jQuery('body').css('overflow-y', '');
                        return;
                    }

                    if (jQuery(this).attr('data-content')) {

                        jQuery('#_cbhtml').append('<div class="is-sidebar-overlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.000001);z-index: 1000;;"></div>');

                        jQuery('.is-sidebar-overlay').off('click');
                        jQuery('.is-sidebar-overlay').on('click', function (e) {
                            jQuery('.is-sidebar-overlay').remove();
                            jQuery('.is-sidebar > div').removeClass('active');
                            jQuery('.is-sidebar-content').removeClass('active');
                            jQuery('body').css('overflow-y', '');
                        });


                        jQuery('.is-sidebar > div').removeClass('active');
                        jQuery('.is-sidebar-content').removeClass('active');
                        jQuery('body').css('overflow-y', '');

                        jQuery(this).addClass('active');
                        var id = jQuery(this).attr('data-content');
                        jQuery('#' + id).addClass('active');
                    }

                    if (jQuery(this).attr('data-command')) {
                        var cmd = jQuery(this).attr('data-command');
                        if (cmd == 'section') {
                            jQuery('.is-wrapper').data('contentbox').viewIdeas();
                        }
                        if (cmd == 'code') {
                            if($element.data("contentbox").settings.htmlSyntaxHighlighting) {
                                jQuery('.is-wrapper').data('contentbox').viewHtml();
                            } else{
                                jQuery('.is-wrapper').data('contentbox').viewHtml2();
                            }
                        }
                        if (cmd == 'typography') {
                            jQuery(this).attr('data-applyto', 'page');
                            jQuery('.is-wrapper').data('contentbox').viewTypography();
                        }
                    }

                    if (jQuery(this).attr('data-src')) {
                        var id = jQuery(this).attr('data-content');
                        if (id == 'divCustomSidebarArea1') {
                            if (jQuery('#ifrCustomSidebarArea1').attr('src').indexOf('blank') != -1) {
                                var src = jQuery(this).attr('data-src');
                                jQuery('#ifrCustomSidebarArea1').attr('src', src);
                            }
                        } else if (id == 'divCustomSidebarArea2') {
                            if (jQuery('#ifrCustomSidebarArea2').attr('src').indexOf('blank') != -1) {
                                var src = jQuery(this).attr('data-src');
                                jQuery('#ifrCustomSidebarArea2').attr('src', src);
                            }
                        } else {
                            var src = jQuery(this).attr('data-src');

                            var id = jQuery(this).attr('data-content');
                            var $iframe = jQuery('#' + id).find('iframe');

                            if($iframe.attr('src').indexOf('blank') != -1) {
                                $iframe.attr('src', src);
                            }
                        }
                    }

                });

            }

            if (!this.settings.useSidebar) {
                jQuery.get(scriptPath + 'contentbox.html', function (data) {
                    var htmlData = '';
                    var htmlThumbs = '';
                    var i = 1;
                    jQuery('<div/>').html(data).children('div').each(function () {

                        var block = jQuery(this).html();

                        var sfind = jQuery(this).attr('data-find');
                        var sreplace = jQuery(this).attr('data-replace');
                        var sfind2 = jQuery(this).attr('data-find2');
                        var sreplace2 = jQuery(this).attr('data-replace2');
                        var sfind3 = jQuery(this).attr('data-find2');
                        var sreplace3 = jQuery(this).attr('data-replace2');

                        var thumb = jQuery(this).attr('data-thumb');

                        if (sfind) {
                            block = block.replace('[%CONTAINER_START%]', $element.data("contentbox").settings.contentHtmlStart.replace(sfind, sreplace));
                            block = block.replace('[%CONTAINER_END%]', $element.data("contentbox").settings.contentHtmlEnd);
                        }
                        if (sfind2) {
                            block = block.replace('[%CONTAINER_START%]', $element.data("contentbox").settings.contentHtmlStart.replace(sfind2, sreplace2));
                            block = block.replace('[%CONTAINER_END%]', $element.data("contentbox").settings.contentHtmlEnd);
                        }
                        if (sfind3) {
                            block = block.replace('[%CONTAINER_START%]', $element.data("contentbox").settings.contentHtmlStart.replace(sfind3, sreplace3));
                            block = block.replace('[%CONTAINER_END%]', $element.data("contentbox").settings.contentHtmlEnd);
                        }
                        block = block.replace('[%CONTAINER_START%]', $element.data("contentbox").settings.contentHtmlStart);
                        block = block.replace('[%CONTAINER_END%]', $element.data("contentbox").settings.contentHtmlEnd);
                        block = block.replace(/\[%IMAGE_PATH%\]/g, scriptPath + 'images/');

                        //Enclode each block. Source: http://stackoverflow.com/questions/1219860/html-encoding-in-javascript-jquery
                        var blockEncoded = jQuery('<div/>').text(block).html(); //Encoded html prevents loading many images

                        if (!$element.data("contentbox").settings.enableModule) {
                            if (jQuery(this).find(".is-module").length == 0 && jQuery(this).find(".is-placeholder").length == 0) {
                                htmlData += '<div id="sect' + i + '">' + blockEncoded + '</div>';
                                htmlThumbs += '<div data-sect="' + i + '"><img src="' + scriptPath + 'images/' + thumb + '"></div>';
                            } else {

                            }
                        } else {
                            htmlData += '<div id="sect' + i + '">' + blockEncoded + '</div>';
                            htmlThumbs += '<div data-sect="' + i + '"><img src="' + scriptPath + 'images/' + thumb + '"></div>';
                        }

                        i++;

                    });

                    jQuery('#divSectionList').html(htmlThumbs);
                    jQuery('#divSections').html(htmlData);

                    jQuery('#divSectionList > *').on('click', function (e) {
                        var newArea = '';
                        newArea = jQuery('#sect' + jQuery(this).attr('data-sect')).text().replace('&lt;', '<').replace('&gt;', '>');

                        //*********** CUSTOMCODE ***********
                        newArea = newArea.replace(/{id}/g, makeid());
                        //*********** /CUSTOMCODE ***********

                        var $newSection;

                        if ($element.children('.is-section').last().hasClass('is-static')) {

                            $element.children('.is-section').last().before(newArea);

                            $newSection = $element.children('.is-section').last().prev();

                        } else {

                            if ($element.children('.is-section').length > 0) {
                                if (!$element.children('.is-section').last().hasClass("is-bg-grey")) {
                                    //$element.append(newArea);
                                    $element.children('.is-section').last().after(newArea);
                                    $element.children('.is-section').last().addClass("is-bg-grey");
                                } else {
                                    //$element.append(newArea);
                                    $element.children('.is-section').last().after(newArea);
                                }
                            } else {
                                $element.prepend(newArea);
                            }
                            $newSection = $element.children('.is-section').last();

                        }

                        //*********** CUSTOMCODE ***********
                        $newSection.find(".is-overlay-content[data-module]").each(function () {//Mode: code
                            var html = (decodeURIComponent(jQuery(this).attr("data-html")));
                            //Fill the block with original code (when adding section)
                            jQuery(this).html(html);
                        });
                        //*********** /CUSTOMCODE ***********

                        _fb.applyBehavior();

                        $newSection.append('<div class="is-section-tool">' +
                            '<div class="is-section-edit" data-title="' + out('Section Settings') + '" title="' + out('Section Settings') + '"><svg class="is-icon-flex" style="margin-right:-2px;fill:rgba(255,255,255,1);"><use xlink:href="#ion-wrench"></use></svg></div>' +
                            '<div class="is-section-remove" data-title="' + out('Remove') + '" title="' + out('Remove') + '">&#10005;</div>' +
                        '</div>');

                        _fb.setTooltip($element.get(0));

                        $newSection.find('.is-section-edit').on('click', function (e) {
                            $activeSection = jQuery(this).parent().parent();

                            $element.data("contentbox").editSection();
                        });

                        $newSection.find('.is-section-remove').on('click', function (e) {

                            jQuery('body, html').animate({
                                scrollTop: $newSection.offset().top
                            }, 1000);

                            //Prepare

                            var $modal = jQuery('.is-modal.delsectionconfirm');
                            $element.data("contentbox").showModal($modal);

                            $modal.not('.is-modal *').off('click');
                            $modal.not('.is-modal *').on('click', function (e) {
                                if (jQuery(e.target).hasClass('is-modal')) {

                                    $element.data("contentbox").hideModal($modal);

                                }
                            });

                            $modal.find('.input-ok').off('click');
                            $modal.find('.input-ok').on('click', function (e) {
                                $newSection.fadeOut(400, function () {
                                    $newSection.remove();

                                    //Trigger Render event
                                    $element.data("contentbox").settings.onRender();

                                    $element.data("contentbox").hideModal($modal);

                                    //Trigger Change event
                                    $element.data("contentbox").settings.onChange();

                                    //Hide box tool
                                    jQuery("#divboxtool").css("display", "none");
                                });
                                return false;
                            });

                        });

                        var $modal = jQuery('.is-modal.addsection');
                        $element.data("contentbox").hideModal($modal);

                        $element.data("contentbox").applyBoxBehavior();

                        jQuery('body, html').animate({
                            scrollTop: $newSection.offset().top
                        }, 1000);

                        //Trigger Change event
                        $element.data("contentbox").settings.onChange();

                        //Close sidebar
                        //jQuery('.is-sidebar > div').removeClass('active');
                        //jQuery('.is-sidebar-content').removeClass('active');

                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    });


                });
            }


            this.setup();


            if (jQuery("#divboxtool").length == 0) {
                var s = '<div id="divboxtool">' +
			        '<form id="form-upload-cover" data-tooltip-top data-title="' + out('Cover') + '" target="frame-upload-cover" method="post" action="' + this.settings.coverImageHandler + '" enctype="multipart/form-data" style="position:relative;width:40px;height:40px;display:inline-block;float:left;background: rgb(90, 156, 38);">' +
                        '<div style="width:40px;height:40px;overflow:hidden;">' +
                            '<div style="position:absolute;width:100%;height:100%;"><svg class="is-icon-flex" style="position: absolute;top: 12px;left: 12px;fill:rgb(255,255,255);"><use xlink:href="#ion-image"></use></svg></div>' +
                            '<input type="file" title="' + out('Cover') + '" id="fileCover" name="fileCover" accept="image/*" style="position:absolute;top:-30px;left:0;width:100%;height:80px;opacity: 0;cursor: pointer;"/>' +
                        '</div>' +
				        '<input id="hidcustomval" name="hidcustomval" type="hidden" value="" />' +
                        '<iframe id="frame-upload-cover" name="frame-upload-cover" src="about:blank" style="width:1px;height:1px;position:absolute;top:0;right:-100000px"></iframe>' +
			        '</form>' +
                    '<div id="lnkeditbox" data-tooltip-top data-title="' + out('Box Settings') + '" title="' + out('Box Settings') + '" style="display:inline-block;width:40px;height:40px;background: rgb(0, 172, 214);"><svg class="is-icon-flex" style="margin-right:-2px;margin-top:9px;fill:rgba(255,255,255,1);"><use xlink:href="#ion-wrench"></use></svg></div>' +
                    '<div id="lnkeditmodule" data-tooltip-top data-title="' + out('Module Settings') + '" title="' + out('Module Settings') + '" style="display:inline-block;width:40px;height:40px;background: #FF9800;"><svg class="is-icon-flex" style="margin-right:-2px;margin-top:9px;fill:rgba(255,255,255,1);"><use xlink:href="#ion-ios-gear"></use></svg></div>' +
		        '</div>';
                //jQuery('body').append(s);
                jQuery('#_cbhtml').append(s);
            }
            jQuery('#hidcustomval').val(this.settings.customval);

            /* re-render/refresh */
            //var y = jQuery(window).scrollTop();
            //jQuery(window).scrollTop(y + 1);

            colorpicker = _fb.colorpicker();

            jQuery('.is-sidebar').on('mouseover', function(){
                jQuery("#divboxtool").css("display", "none");
                jQuery('.is-section-tool').css('display', 'none');
            });

        };
        // init()

        this.addButton = function(btn) {
            var btnId = makeid();
            var panelId = makeid();
            var btnHtml = '<div id="' + btnId + '" class="is-sidebar-button" data-content="' + panelId + '" data-src="' + btn.src + '" data-title="' + out(btn.title) + '" title="' + out(btn.title) + '">' +
                btn.html +
            '</div>';
            jQuery('.is-sidebar > *:eq(' + btn.pos + ')').after(btnHtml);

            var panelHtml =
            '<div id="' + panelId + '" class="is-sidebar-content ' + btn.class + '" style="-webkit-transition-duration:0.2s;transition-duration:0.2s;">' +
                '<div>' +
                    '<iframe src="about:blank" style="width:100%;height:100%;box-sizing:border-box;border:none;">' +
                    '</iframe>' +
                '</div>' +
            '</div>';
            jQuery('#_cbhtml').append(panelHtml);

            jQuery('#' + btnId).on('click', function(e){
                if(!jQuery(this).hasClass('active')) {

                    jQuery('.is-sidebar > div').removeClass('active');
                    jQuery('.is-sidebar-content').removeClass('active');
                    jQuery('body').css('overflow-y', '');

                    jQuery(this).addClass('active');
                    var id = jQuery(this).attr('data-content');
                    jQuery('#' + id).addClass('active');

                    var $iframe = jQuery('#' + id + ' iframe');
                    if($iframe.attr('src') == 'about:blank') {
                        $iframe.attr('src', btn.src);
                    }

                    jQuery('#_cbhtml').append('<div class="is-sidebar-overlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.000001);z-index: 1000;;"></div>');

                    jQuery('.is-sidebar-overlay').off('click');
                    jQuery('.is-sidebar-overlay').on('click', function (e) {
                        jQuery('.is-sidebar-overlay').remove();
                        jQuery('.is-sidebar > div').removeClass('active');
                        jQuery('.is-sidebar-content').removeClass('active');
                        jQuery('body').css('overflow-y', '');
                    });

                } else {
                    jQuery('.is-sidebar-overlay').remove();
                    jQuery('.is-sidebar > div').removeClass('active');
                    jQuery('.is-sidebar-content').removeClass('active');
                    jQuery('body').css('overflow-y', '');
                    return;
                }
            });

        };

        this.saveImages = function(handler, onComplete) {
            _fb.saveImages(handler, onComplete);
        };

        this.showModal = function ($modal) {

            $modal.addClass('active');

        };

        this.hideModal = function ($modal) {
            $modal.removeClass('active');
        };

        this.addIdea = function (newArea) {

            _fb.saveForUndo();

            var designPath = $element.data("contentbox").settings.designPath;

            newArea = newArea.replace(/\[%IMAGE_PATH%\]/g, designPath);
            newArea = newArea.replace(/%5B%25IMAGE_PATH%25%5D/g, designPath); //If [%IMAGE_PATH%] is encoded (inside data-html)

            var $newSection;
            if (newArea.indexOf('is-static') == -1 && $element.children('.is-section').last().hasClass('is-static')) {

                $element.children('.is-section').last().before(newArea);

                $newSection = $element.children('.is-section').last().prev();

                if ($newSection.prev()) {
                    if (!$newSection.prev().hasClass("is-bg-grey")) {
                        $newSection.addClass("is-bg-grey");
                    }
                }

            } else {

                if ($element.children('.is-section').length > 0) {
                    /*
                    if (!$element.children('.is-section').last().hasClass("is-bg-grey")) {
                    //$element.append(newArea);
                    $element.children('.is-section').last().after(newArea);
                    $element.children('.is-section').last().addClass("is-bg-grey");
                    } else {
                    //$element.append(newArea);
                    $element.children('.is-section').last().after(newArea);
                    }*/

                    $element.children('.is-section').last().after(newArea);

                } else {
                    $element.prepend(newArea);
                }

                $newSection = $element.children('.is-section').last();

                if ($newSection.prev()) {
                    if (!$newSection.prev().hasClass("is-bg-grey")) {
                        $newSection.addClass("is-bg-grey");
                    }
                }

            }

            //*********** CUSTOMCODE ***********
            $newSection.find(".is-overlay-content[data-module]").each(function () {//Mode: code
                var html = (decodeURIComponent(jQuery(this).attr("data-html")));

                html = html.replace(/{id}/g, makeid());

                //Fill the block with original code (when adding section)
                jQuery(this).html(html);
            });
            //*********** /CUSTOMCODE ***********

            _fb.applyBehavior();

            $newSection.append('<div class="is-section-tool">' +
                '<div class="is-section-edit" data-title="' + out('Section Settings') + '" title="' + out('Section Settings') + '"><svg class="is-icon-flex" style="margin-right:-2px;fill:rgba(255,255,255,1);"><use xlink:href="#ion-wrench"></use></svg></div>' +
                '<div class="is-section-remove" data-title="' + out('Remove') + '" title="' + out('Remove') + '">&#10005;</div>' +
            '</div>');

            _fb.setTooltip($element.get(0));

            $newSection.find('.is-section-edit').on('click', function (e) {
                $activeSection = jQuery(this).parent().parent();

                $element.data("contentbox").editSection();
            });

            $newSection.find('.is-section-remove').on('click', function (e) {

                jQuery('body, html').animate({
                    scrollTop: $newSection.offset().top
                }, 1000);

                //Prepare

                var $modal = jQuery('.is-modal.delsectionconfirm');
                $element.data("contentbox").showModal($modal);

                $modal.not('.is-modal *').off('click');
                $modal.not('.is-modal *').on('click', function (e) {
                    if (jQuery(e.target).hasClass('is-modal')) {

                        $element.data("contentbox").hideModal($modal);

                    }
                });

                $modal.find('.input-ok').off('click');
                $modal.find('.input-ok').on('click', function (e) {
                    $newSection.fadeOut(400, function () {
                        $newSection.remove();

                        //Trigger Render event
                        $element.data("contentbox").settings.onRender();

                        $element.data("contentbox").hideModal($modal);

                        //Trigger Change event
                        $element.data("contentbox").settings.onChange();

                        //Hide box tool
                        jQuery("#divboxtool").css("display", "none");
                    });
                    return false;
                });

            });

            $element.data("contentbox").applyBoxBehavior();

            //$('body, html').scrollTop($newSection.offset().top);
            jQuery('body, html').animate({
                scrollTop: $newSection.offset().top
            }, 1000);

            //Trigger Change event
            $element.data("contentbox").settings.onChange();

            //Close sidebar
            jQuery('.is-sidebar-overlay').remove();
            jQuery('.is-sidebar > div').removeClass('active');
            jQuery('.is-sidebar-content').removeClass('active');
            jQuery('body').css('overflow-y', '');

        };

        this.setup = function () {

            $element.children('.is-section').each(function () {

                var $currentSection = jQuery(this);

                //if ($currentSection.hasClass('is-static')) return;

                if ($currentSection.find('.is-boxes').length == 0 && !$currentSection.hasClass('is-stretch')) {
                    //$currentSection.html('<div class="is-boxes"><div class="is-box-centered">' + $currentSection.html() + '</div></div>');
                    //$currentSection.addClass('is-box');
                }

                $currentSection.append('<div class="is-section-tool">' +
                        '<div class="is-section-edit" data-title="' + out('Section Settings') + '" title="' + out('Section Settings') + '"><svg class="is-icon-flex" style="margin-right:-2px;fill:rgba(255,255,255,1);"><use xlink:href="#ion-wrench"></use></svg></div>' +
                        '<div class="is-section-remove" data-title="' + out('Remove') + '" title="' + out('Remove') + '">&#10005;</div>' +
                    '</div>');

                _fb.setTooltip($element.get(0));

                $currentSection.find(".is-section-edit").off('click');
                $currentSection.find(".is-section-edit").on('click', function (e) {
                    $activeSection = jQuery(this).parent().parent();

                    $element.data("contentbox").editSection();
                });

                $currentSection.find(".is-section-remove").off('click');
                $currentSection.find(".is-section-remove").on('click', function (e) {

                    jQuery('body, html').animate({
                        scrollTop: $currentSection.offset().top
                    }, 1000);

                    //Prepare

                    var $modal = jQuery('.is-modal.delsectionconfirm');
                    $element.data("contentbox").showModal($modal);

                    $modal.not('.is-modal *').off('click');
                    $modal.not('.is-modal *').on('click', function (e) {
                        if (jQuery(e.target).hasClass('is-modal')) {

                            $element.data("contentbox").hideModal($modal);

                        }
                    });

                    $modal.find('.input-ok').off('click');
                    $modal.find('.input-ok').on('click', function (e) {
                        $currentSection.fadeOut(400, function () {

                            _fb.saveForUndo();

                            $currentSection.remove();

                            //Trigger Render event
                            $element.data("contentbox").settings.onRender();

                            $element.data("contentbox").hideModal($modal);

                            //Trigger Change event
                            $element.data("contentbox").settings.onChange();

                            //Hide box tool
                            jQuery("#divboxtool").css("display", "none");
                        });
                        return false;
                    });

                });


            });

            this.applyBoxBehavior();

            _fb.applyBehavior();

        };

        this.loadHtml = function (html) {
            $element.html(html);
            this.setup();
        };

        this.addSection = function () {

            //Trigger onAddSectionOpen event
            this.settings.onAddSectionOpen();

            var $modal = jQuery('.is-modal.addsection');
            $element.data("contentbox").showModal($modal);

        };

        this.editSection = function () {

            jQuery('body, html').animate({
                scrollTop: $activeSection.offset().top
            }, 1000);

            //Prepare

            var $modal = jQuery('.is-modal.editsection');
            $element.data("contentbox").showModal($modal);

            $modal.not('.is-modal *').off('click');
            $modal.not('.is-modal *').on('click', function (e) {
                if (jQuery(e.target).hasClass('is-modal')) {
                    $element.data("contentbox").hideModal($modal);
                }
            });


            if ($activeSection.hasClass('is-static')) {
                jQuery('.move-section').css('display', 'none');
                jQuery('.add-scroll-section').css('display', 'none');
            } else {
                jQuery('.move-section').css('display', 'table');
                jQuery('.add-scroll-section').css('display', 'table');
            }


            jQuery(".cmd-section-up").off('click');
            jQuery(".cmd-section-up").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").sectionUp();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });
            jQuery(".cmd-section-down").off('click');
            jQuery(".cmd-section-down").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").sectionDown();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-section-top").unbind("click");
            jQuery(".cmd-section-top").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").sectionTop();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });
            jQuery(".cmd-section-bottom").unbind("click");
            jQuery(".cmd-section-bottom").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").sectionBottom();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });
            jQuery(".cmd-section-height").unbind("click");
            jQuery(".cmd-section-height").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").sectionHeight(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });
            jQuery(".cmd-section-scroll").unbind("click");
            jQuery(".cmd-section-scroll").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").sectionScrollIcon(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            if ($activeSection.find(".is-arrow-down").length > 0) {
                jQuery("#chkScrollIcon").prop("checked", true);
            } else {
                jQuery("#chkScrollIcon").prop("checked", false);
            }
            jQuery("#chkScrollIcon").unbind("click");
            jQuery("#chkScrollIcon").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").sectionUseScroll();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

            });

        };

        this.applyBoxBehavior = function () {

            jQuery(".is-box").on('mouseenter mouseleave', function (e) {
                switch (e.type) {
                    case 'mouseenter':

                        var $box = jQuery(this);

                        var leftadj;

                        if ($box.find('.is-overlay-content[data-module]').length > 0) {
                            jQuery("#form-upload-cover").css("display", "none");
                            jQuery("#lnkeditmodule").css("display", "inline-block");
                            jQuery("#divboxtool").css("width", "80px");
                            leftadj = 55;
                        } else {
                            jQuery("#form-upload-cover").css("display", "block");
                            jQuery("#lnkeditmodule").css("display", "none");
                            jQuery("#divboxtool").css("width", "80px");
                            leftadj = 40;
                        }

                        /* always show camera icon (except stretched module section which doesn't have is-boxes
                        if ($box.find(".is-boxes").length > 0) {
                        jQuery("#form-upload-cover").css("display", "block");
                        leftadj = 30;
                        jQuery("#divboxtool").css("width", "60px");
                        } else {
                        jQuery("#form-upload-cover").css("display", "none");
                        leftadj = 15;
                        jQuery("#divboxtool").css("width", "30px");
                        }
                        */

                        var scrolltop = jQuery(window).scrollTop();
                        var offsettop = $box.offset().top;
                        var offsetleft = $box.offset().left;
                        var top = offsettop + parseInt($box.css('height')) - 40;
                        var left = offsetleft + parseInt($box.css('width')) / 2;
                        jQuery("#divboxtool").css("top", top + "px");
                        jQuery("#divboxtool").css("left", (left - leftadj) + "px");
                        //jQuery("#divboxtool").fadeIn(300);
                        jQuery("#divboxtool").css("display", "flex");

                        jQuery('.is-section-tool').css('display', 'none');
                        if(jQuery(this).hasClass('is-section')) {
                            jQuery(this).find('.is-section-tool').css('display', 'block');
                        } else {
                            jQuery(this).parents('.is-section').first().find('.is-section-tool').css('display', 'block');

                        }
                        // Prevent flickr
                        // jQuery("#divboxtool").on('mouseenter mouseleave', function (e) {
                        //     switch (e.type) {
                        //         case 'mouseenter':
                        //             jQuery("#divboxtool").stop(true, true).css("display", "flex");
                        //             break;
                        //         case 'mouseleave':
                        //             jQuery("#divboxtool").stop(true, true).fadeOut(0);
                        //             break;
                        //     }
                        // });

                        jQuery("#fileCover").off('click');
                        jQuery("#fileCover").on('click', function (e) {

                            $activeBox = $box;
                            $activeSection = $box.parents('is-section');

                        });

                        jQuery("#lnkeditbox").off('click');
                        jQuery("#lnkeditbox").on('click', function (e) {

                            $activeBox = $box;
                            $activeSection = $box.parents('is-section');

                            $element.data("contentbox").editBox();

                        });

                        jQuery("#lnkeditmodule").off('click');
                        jQuery("#lnkeditmodule").on('click', function (e) {

                            $activeBox = $box;
                            $activeSection = $box.parents('is-section');

                            $element.data("contentbox").editModule();
                        });


                        jQuery("#fileCover").off('change');
                        jQuery("#fileCover").on('change', function (e) {

                            if (jQuery(this).val() == '') return;

                            _fb.saveForUndo();

                            jQuery("#lblWait").css("display", "block");
                            jQuery("#form-upload-cover").submit();

                            jQuery(this).clearInputs();

                            e.preventDefault();
                            e.stopImmediatePropagation();
                        });

                        break;
                    case 'mouseleave':
                        // jQuery("#divboxtool").stop(true, true).fadeOut(0); // new
                        break;
                }
            });

            /*
            Add dummy DIV after the last section (for the ability to adjust last section according bottom bar).
            In FF, needed only when adding new section.
            In IE, needed on normal.
            */
            if ($element.children('div.is-dummy').length > 0) {
                $element.children('div.is-dummy').remove();
            }
            $element.append('<div class="is-dummy" style="height:0px;"></div>'); //always on the last

            if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
                //Safari doesn't need the DIV
                jQuery('div.is-dummy').remove();
            }

            //Trigger Render event
            this.settings.onRender();
        };

        this.editModule = function () {

            jQuery('body, html').animate({
                scrollTop: $activeBox.offset().top
            }, 1000);

            var $activeModule = $activeBox.find(".is-overlay-content[data-module]");

            jQuery("[data-module-active]").removeAttr('data-module-active');
            $activeModule.attr('data-module-active', '1');

            var moduleName = $activeModule.attr('data-module');

            if (moduleName == 'code') {

                if($element.data("contentbox").settings.htmlSyntaxHighlighting) {

                    $activeBox.addClass('box-active');

                    var html = decodeURIComponent($activeModule.attr("data-html"));

                    jQuery('#txtBoxCustomCode').val(html);

                    jQuery('textarea').removeAttr('data-source-active');
                    jQuery('textarea').removeAttr('data-source-ok');
                    jQuery('textarea').removeAttr('data-source-cancel');
                    jQuery('.editcustomcode textarea').attr('data-source-active', '1');
                    jQuery('.editcustomcode textarea').attr('data-source-ok', '.editcustomcode .input-ok');
                    jQuery('.editcustomcode textarea').attr('data-source-cancel', '.editcustomcode');

                    _fb.viewHtmlNormal();

                    var $modal = jQuery('.is-modal.editcustomcode');
                    $modal.find('.input-ok').off('click');
                    $modal.find('.input-ok').on('click', function (e) {

                        _fb.saveForUndo();

                        jQuery('#hidBoxCustomCode').val(jQuery('#txtBoxCustomCode').val());

                        //Save Html (original)
                        $activeModule.attr('data-html', encodeURIComponent(jQuery('#hidBoxCustomCode').val()));

                        //Render (programmatically)
                        $activeModule.html(jQuery('#hidBoxCustomCode').val());

                        //Trigger Change event
                        $element.data("contentbox").settings.onChange();

                        $element.data("contentbox").hideModal($modal);
                        jQuery('.box-active').removeClass('box-active');

                    });

                } else {

                    $activeBox.addClass('box-active');

                    var $modal = jQuery('.is-modal.editcustomcode');
                    $element.data("contentbox").showModal($modal);

                    $modal.not('.is-modal *').off('click');
                    $modal.not('.is-modal *').on('click', function (e) {
                        if (jQuery(e.target).hasClass('is-modal')) {
                            $element.data("contentbox").hideModal($modal);
                            jQuery('.box-active').removeClass('box-active');
                        }
                    });

                    var html = decodeURIComponent($activeModule.attr("data-html"));
                    jQuery('#txtBoxCustomCode').val(html);
                    jQuery('#txtBoxCustomCode').trigger('focus');

                    jQuery('.editcustomcode .cell-html-larger').off('click');
                    jQuery('.editcustomcode .cell-html-larger').on('click', function (e) {

                        //used  by larger editor dialog (html.html)
                        jQuery('textarea').removeAttr('data-source-active');
                        jQuery('textarea').removeAttr('data-source-ok');
                        jQuery('textarea').removeAttr('data-source-cancel');
                        jQuery('.editcustomcode textarea').attr('data-source-active', '1');
                        jQuery('.editcustomcode textarea').attr('data-source-ok', '.editcustomcode .input-ok');
                        jQuery('.editcustomcode textarea').attr('data-source-cancel', '.editcustomcode');

                        _fb.viewHtmlLarger();

                    });

                    $modal.find('.input-ok').off('click');
                    $modal.find('.input-ok').on('click', function (e) {

                        _fb.saveForUndo();

                        jQuery('#hidBoxCustomCode').val(jQuery('#txtBoxCustomCode').val());

                        //Save Html (original)
                        $activeModule.attr('data-html', encodeURIComponent(jQuery('#hidBoxCustomCode').val()));

                        //Render (programmatically)
                        $activeModule.html(jQuery('#hidBoxCustomCode').val());

                        //Trigger Change event
                        $element.data("contentbox").settings.onChange();

                        $element.data("contentbox").hideModal($modal);
                        jQuery('.box-active').removeClass('box-active');

                    });

                }


            } else {
                $activeBox.addClass('box-active');

                var $modal = jQuery('.is-modal.editmodule');
                $element.data("contentbox").showModal($modal);

                $modal.not('.is-modal *').off('click');
                $modal.not('.is-modal *').on('click', function (e) {
                    if (jQuery(e.target).hasClass('is-modal')) {
                        $element.data("contentbox").hideModal($modal);
                        jQuery('.box-active').removeClass('box-active');
                    }
                });

                $modal.find('iframe').attr('src', $element.data('contentbox').settings.modulePath + moduleName + '.html'); //load module panel on iframe

                var moduleDesc = $activeModule.attr('data-module-desc');
                if (moduleDesc) {
                    $modal.find('.is-modal-bar').html(moduleDesc);
                } else {
                    $modal.find('.is-modal-bar').html('Module Settings');
                }

                var w = $activeModule.attr('data-dialog-width');
                if (!w || w == '') {
                    w = '900px';
                }

                var h = $activeModule.attr('data-dialog-height');
                if (!h || h == '') {
                    h = '570px';
                }

                $modal.children('div').first().css('max-width', w);
                $modal.children('div').first().css('height', h);

                $modal.find('.input-ok').off('click');
                $modal.find('.input-ok').on('click', function (e) {

                    _fb.saveForUndo();

                    if (moduleName == 'code') {
                        var $codeEditor = jQuery('#txtBoxCustomCode').data('CodeMirrorInstance');
                        jQuery('#hidBoxCustomCode').val($codeEditor.getValue());
                    }

                    //Save Html (original)
                    $activeModule.attr('data-html', encodeURIComponent(jQuery('#hidModuleCode').val()));

                    //Save Settings (original)
                    $activeModule.attr('data-settings', encodeURIComponent(jQuery('#hidModuleSettings').val()));

                    //Render (programmatically)
                    $activeModule.html(jQuery('#hidModuleCode').val());

                    //Trigger Change event
                    $element.data("contentbox").settings.onChange();

                    $element.data("contentbox").hideModal($modal);

                    jQuery('.box-active').removeClass('box-active');
                });

            }

        };

        this.editBox = function () {

            jQuery('body, html').animate({
                scrollTop: $activeBox.offset().top
            }, 1000);

            //Show/Hide Tabs
            if ($activeBox.find(".is-overlay-bg").length == 0) {
                jQuery("#tabBoxImage").css("display", "none");
                jQuery("#divBoxPickPhoto").css("display", "none");

                jQuery("#tabBoxModule").css("display", "none"); //hide chkBgModule

            } else {
                jQuery("#tabBoxImage").css("display", "inline-block");
                if ($element.data("contentbox").settings.photoselect == '') {
                    jQuery("#divBoxPickPhoto").css("display", "none");
                } else {
                    jQuery("#divBoxPickPhoto").css("display", "block");
                }

                if (!$element.data("contentbox").settings.enableModule) {
                    jQuery("#tabBoxModule").css("display", "none");
                } else {
                    jQuery("#tabBoxModule").css("display", "inline-block");
                }

                if ($activeBox.find(".is-overlay-bg").children().not('.is-overlay-color').length > 0) { //There is content within background overlay
                    jQuery("#chkAnimateBg").parents(".is-settings").css("display", "none");
                    jQuery("#chkParallaxBg").parents(".is-settings").css("display", "none");
                } else {
                    jQuery("#chkAnimateBg").parents(".is-settings").css("display", "inline-block");
                    jQuery("#chkParallaxBg").parents(".is-settings").css("display", "inline-block");
                }

            }

            if (!$element.data("contentbox").settings.enableAnimation) {
                jQuery("#tabBoxAnimate").css("display", "none");
            } else {
                jQuery("#tabBoxAnimate").css("display", "inline-block");
            }

            if ($activeBox.find(".is-container").length == 0) { //no content
                jQuery("#tabBoxContentText").css("display", "none");
                jQuery("#tabBoxContentContainer").css("display", "none");
                jQuery("#divContentSize").css("display", "none");
            } else {

                if ($activeBox.find(".is-container .is-module").length > 0) {
                    jQuery("#tabBoxContentText").css("display", "none");
                } else {
                    jQuery("#tabBoxContentText").css("display", "inline-block");
                }

                if ($activeBox.css("display") == "table" || $activeBox.css("display") == "table-cell" || $activeBox.css("display") == "flex") {
                    jQuery("#tabBoxContentContainer").css("display", "inline-block");
                    jQuery("#divContentSize").css("display", "inline-block");
                } else {
                    jQuery("#tabBoxContentContainer").css("display", "none");
                    jQuery("#divContentSize").css("display", "none");
                }
            }

            if ($activeBox.find(".is-module").length > 0) { //If is module
                jQuery("#chkBgModule").prop("checked", true);
            } else {
                jQuery("#chkBgModule").prop("checked", false);
            }

            if ($activeBox.find(".is-overlay-content[data-module]").length != 0) {
                jQuery("#divBoxBackgroundColor").css("display", "none");
                jQuery("#tabBoxImage").css("display", "none");
            } else {
                jQuery("#divBoxBackgroundColor").css("display", "block");
            }

            if (jQuery("#divBoxBackgroundColor").css("display") == "block") {
                if ($activeBox.find(".is-overlay-bg").children().not('.is-overlay-color').length > 0) { //There is content within background overlay
                    jQuery("#divBoxBackgroundColor").css("display", "none");
                }
            }

            if ($activeBox.find(".is-overlay-bg").length > 0) {

                if ($activeBox.find(".is-overlay-bg").hasClass("is-scale-animated")) {
                    jQuery("#chkAnimateBg").prop("checked", true);
                } else {
                    jQuery("#chkAnimateBg").prop("checked", false);
                }

                if ($activeBox.find(".is-overlay-bg").attr("style").indexOf("scale(1.05)") != -1) {
                    jQuery("#chkParallaxBg").prop("checked", true);
                } else {
                    jQuery("#chkParallaxBg").prop("checked", false);
                }
            }

            if ($activeBox.hasClass("is-section")) {
                jQuery("#divBoxSize").css("display", "none");
            } else {
                jQuery("#divBoxSize").css("display", "block");
            }

            if (jQuery("#divBoxSize").css("display") == "none" &&
                jQuery("#divBoxBackgroundColor").css("display") == "none" &&
                jQuery("#tabBoxContentText").css("display") == "none" &&
                jQuery("#tabBoxContentContainer").css("display") == "none" &&
                jQuery("#tabBoxImage").css("display") == "none" &&
                jQuery("#tabBoxModule").css("display") == "none" &&
                jQuery("#tabBoxAnimate").css("display") == "none" &&
                jQuery("#tabBoxCustomHtml").css("display") == "none") {

                jQuery("#divNoBoxSettings").css("display", "block"); //Show info: This box has no available settings
            } else {
                jQuery("#divNoBoxSettings").css("display", "none"); //Hide info
            }

            //Prepare

            //$activeBox.prepend('<div class="box-active"></div>')
            $activeBox.addClass('box-active');

            var $modal = jQuery('.is-modal.editbox');
            $element.data("contentbox").showModal($modal);

            $modal.not('.is-modal *').off('click');
            $modal.not('.is-modal *').on('click', function (e) {
                if (jQuery(e.target).hasClass('is-modal')) {
                    $element.data("contentbox").hideModal($modal);
                    //jQuery('.box-active').remove();
                    jQuery('.box-active').removeClass('box-active');
                }
            });

            $modal.find('.is-tabs a').off('click');
            $modal.find('.is-tabs a').on('click', function () {

                if (jQuery(this).hasClass('active')) return false;

                $modal.find('.is-tabs > a').removeClass('active');
                jQuery(this).addClass('active');

                var id = jQuery(this).attr('data-content');

                $modal.find('.is-tab-content ').css('display', 'none');
                jQuery('#' + id).css('display', 'block');

                return false;
            });

            $modal.find('#tabBoxGeneral').trigger('click');

            //Settings

            jQuery(".inp-box-size").val(parseInt($activeBox.find(".is-container").css("max-width")));

            jQuery('#inpBoxBgColor').val($activeBox.get(0).style.backgroundColor);

            jQuery(".cmd-box-smaller").unbind("click");
            jQuery(".cmd-box-smaller").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxWidthSmaller(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-box-larger").unbind("click");
            jQuery(".cmd-box-larger").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxWidthLarger(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });


            jQuery(".cmd-box-bgcolor").unbind("click");
            jQuery(".cmd-box-bgcolor").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxBgColor(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-box-textcolor").unbind("click");
            jQuery(".cmd-box-textcolor").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxTextColor(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });
            jQuery(".cmd-box-textalign").unbind("click");
            jQuery(".cmd-box-textalign").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxTextAlign(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });
            jQuery(".cmd-box-textopacity").unbind("click");
            jQuery(".cmd-box-textopacity").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxTextOpacity(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });
            jQuery(".cmd-box-typography").unbind("click");
            jQuery(".cmd-box-typography").on('click', function (e) {

                $element.data("contentbox").hideModal($modal);

                //Open divSidebarTypography
                jQuery('.is-sidebar > div[data-command=typography]').click();
                jQuery('.is-sidebar > div[data-command=typography]').attr('data-applyto', 'box');

                return false;
            });

            jQuery(".cmd-box-size").unbind("click");
            jQuery(".cmd-box-size").on('click', function (e) {

                _fb.saveForUndo();

                //$element.data("contentbox").boxWidth(jQuery(this).data("value"));

                //backward
                $activeBox.find(".is-container").removeClass("is-content-380");
                $activeBox.find(".is-container").removeClass("is-content-500");
                $activeBox.find(".is-container").removeClass("is-content-640");
                $activeBox.find(".is-container").removeClass("is-content-800");
                $activeBox.find(".is-container").removeClass("is-content-970");
                $activeBox.find(".is-container").removeClass("is-content-980");
                $activeBox.find(".is-container").removeClass("is-content-1050");
                $activeBox.find(".is-container").removeClass("is-content-1100");
                $activeBox.find(".is-container").removeClass("is-content-1200");

                var val = jQuery(this).data("value");
                if (val == '-') {
                    var val = parseInt($activeBox.find(".is-container").css("max-width")) - 20;
                } else if (val == '+') {
                    var val = parseInt($activeBox.find(".is-container").css("max-width")) + 20;
                }
                if(val<=250) val=250;
                $activeBox.find(".is-container").css("max-width", val + "px");

                jQuery(".inp-box-size").val(val);

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".inp-box-size").unbind("keyup");
            jQuery(".inp-box-size").on("keyup", function (e) {

                //backward
                $activeBox.find(".is-container").removeClass("is-content-380");
                $activeBox.find(".is-container").removeClass("is-content-500");
                $activeBox.find(".is-container").removeClass("is-content-640");
                $activeBox.find(".is-container").removeClass("is-content-800");
                $activeBox.find(".is-container").removeClass("is-content-970");
                $activeBox.find(".is-container").removeClass("is-content-980");
                $activeBox.find(".is-container").removeClass("is-content-1050");
                $activeBox.find(".is-container").removeClass("is-content-1100");
                $activeBox.find(".is-container").removeClass("is-content-1200");

                var val = jQuery(".inp-box-size").val();
                if(!isNaN(val) && val>=250) {
                    $activeBox.find(".is-container").css("max-width", val + "px");
                }

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-box-content-pos").unbind("click");
            jQuery(".cmd-box-content-pos").on('click', function (e) {

                _fb.saveForUndo();

                $activeBox.find(".edge-y--5").removeClass("edge-y--5");
                $activeBox.find(".edge-y--4").removeClass("edge-y--4");
                $activeBox.find(".edge-y--3").removeClass("edge-y--3");
                $activeBox.find(".edge-y--2").removeClass("edge-y--2");
                $activeBox.find(".edge-y--1").removeClass("edge-y--1");
                $activeBox.find(".edge-y-0").removeClass("edge-y-0");
                $activeBox.find(".edge-y-1").removeClass("edge-y-1");
                $activeBox.find(".edge-y-2").removeClass("edge-y-2");
                $activeBox.find(".edge-y-3").removeClass("edge-y-3");
                $activeBox.find(".edge-y-4").removeClass("edge-y-4");
                $activeBox.find(".edge-y-5").removeClass("edge-y-5");

                $activeBox.find(".edge-x-0").removeClass("edge-x-0");
                $activeBox.find(".edge-x-1").removeClass("edge-x-1");
                $activeBox.find(".edge-x-2").removeClass("edge-x-2");
                $activeBox.find(".edge-x-3").removeClass("edge-x-3");
                $activeBox.find(".edge-x-4").removeClass("edge-x-4");
                $activeBox.find(".edge-x-5").removeClass("edge-x-5");

                $activeBox.find(".is-box-centered").removeClass("is-content-top");
                $activeBox.find(".is-box-centered").removeClass("is-content-bottom");
                $activeBox.removeClass("is-content-top"); //simplified
                $activeBox.removeClass("is-content-bottom"); //simplified

                $activeBox.find(".is-container").removeClass("is-content-left");
                $activeBox.find(".is-container").removeClass("is-content-right");

                var s = jQuery(this).data("value");
                if (s == "topleft") {
                    $activeBox.find(".is-box-centered").addClass("is-content-top");
                    $activeBox.addClass("is-content-top"); //simplified

                    $activeBox.find(".is-container").addClass("is-content-left");
                }
                if (s == "topcenter") {
                    $activeBox.find(".is-box-centered").addClass("is-content-top");
                    $activeBox.addClass("is-content-top"); //simplified

                    $activeBox.find(".is-container").removeClass("is-content-left");
                }
                if (s == "topright") {
                    $activeBox.find(".is-box-centered").addClass("is-content-top");
                    $activeBox.addClass("is-content-top"); //simplified

                    $activeBox.find(".is-container").addClass("is-content-right");
                }
                if (s == "middleleft") {
                    $activeBox.find(".is-container").addClass("is-content-left");
                }
                if (s == "middlecenter") {

                }
                if (s == "middleright") {
                    $activeBox.find(".is-container").addClass("is-content-right");
                }
                if (s == "bottomleft") {
                    $activeBox.find(".is-box-centered").addClass("is-content-bottom");
                    $activeBox.addClass("is-content-bottom"); //simplified

                    $activeBox.find(".is-container").addClass("is-content-left");
                }
                if (s == "bottomcenter") {
                    $activeBox.find(".is-box-centered").addClass("is-content-bottom");
                    $activeBox.addClass("is-content-bottom"); //simplified
                }
                if (s == "bottomright") {
                    $activeBox.find(".is-box-centered").addClass("is-content-bottom");
                    $activeBox.addClass("is-content-bottom"); //simplified

                    $activeBox.find(".is-container").addClass("is-content-right");
                }

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-box-content-edge-x").unbind("click");
            jQuery(".cmd-box-content-edge-x").on('click', function (e) {

                _fb.saveForUndo();

                var s = jQuery(this).data("value");
                if (s == "-") {
                    if ($activeBox.find(".is-container").hasClass("edge-x-0")) { return false; ; }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-1")) { $activeBox.find(".is-container").removeClass("edge-x-1"); $activeBox.find(".is-container").addClass("edge-x-0"); }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-2")) { $activeBox.find(".is-container").removeClass("edge-x-2"); $activeBox.find(".is-container").addClass("edge-x-1") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-3")) { $activeBox.find(".is-container").removeClass("edge-x-3"); $activeBox.find(".is-container").addClass("edge-x-2") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-4")) { $activeBox.find(".is-container").removeClass("edge-x-4"); $activeBox.find(".is-container").addClass("edge-x-3") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-5")) { $activeBox.find(".is-container").removeClass("edge-x-5"); $activeBox.find(".is-container").addClass("edge-x-4") }
                    else { $activeBox.find(".is-container").addClass("edge-x-0"); }
                }
                if (s == "+") {
                    if ($activeBox.find(".is-container").hasClass("edge-x-0")) { $activeBox.find(".is-container").removeClass("edge-x-0"); $activeBox.find(".is-container").addClass("edge-x-1") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-1")) { $activeBox.find(".is-container").removeClass("edge-x-1"); $activeBox.find(".is-container").addClass("edge-x-2") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-2")) { $activeBox.find(".is-container").removeClass("edge-x-2"); $activeBox.find(".is-container").addClass("edge-x-3") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-3")) { $activeBox.find(".is-container").removeClass("edge-x-3"); $activeBox.find(".is-container").addClass("edge-x-4") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-4")) { $activeBox.find(".is-container").removeClass("edge-x-4"); $activeBox.find(".is-container").addClass("edge-x-5") }
                    else if ($activeBox.find(".is-container").hasClass("edge-x-5")) { return false; }
                    else { $activeBox.find(".is-container").addClass("edge-x-0") }
                }
                if (s == "") {
                    $activeBox.find(".is-container").removeClass("edge-x-0");
                    $activeBox.find(".is-container").removeClass("edge-x-1");
                    $activeBox.find(".is-container").removeClass("edge-x-2");
                    $activeBox.find(".is-container").removeClass("edge-x-3");
                    $activeBox.find(".is-container").removeClass("edge-x-4");
                    $activeBox.find(".is-container").removeClass("edge-x-5");
                }

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;

            });

            jQuery(".cmd-box-content-edge-y").unbind("click");
            jQuery(".cmd-box-content-edge-y").on('click', function (e) {

                _fb.saveForUndo();

                var s = jQuery(this).data("value");
                if (s == "-") {
                    if ($activeBox.find(".is-box-centered").hasClass("edge-y--5")) { return false; }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--4")) { $activeBox.find(".is-box-centered").removeClass("edge-y--4"); $activeBox.find(".is-box-centered").addClass("edge-y--5") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--3")) { $activeBox.find(".is-box-centered").removeClass("edge-y--3"); $activeBox.find(".is-box-centered").addClass("edge-y--4") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--2")) { $activeBox.find(".is-box-centered").removeClass("edge-y--2"); $activeBox.find(".is-box-centered").addClass("edge-y--3") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--1")) { $activeBox.find(".is-box-centered").removeClass("edge-y--1"); $activeBox.find(".is-box-centered").addClass("edge-y--2") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-0")) { $activeBox.find(".is-box-centered").removeClass("edge-y-0"); $activeBox.find(".is-box-centered").addClass("edge-y--1"); }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-1")) { $activeBox.find(".is-box-centered").removeClass("edge-y-1"); $activeBox.find(".is-box-centered").addClass("edge-y-0"); }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-2")) { $activeBox.find(".is-box-centered").removeClass("edge-y-2"); $activeBox.find(".is-box-centered").addClass("edge-y-1") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-3")) { $activeBox.find(".is-box-centered").removeClass("edge-y-3"); $activeBox.find(".is-box-centered").addClass("edge-y-2") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-4")) { $activeBox.find(".is-box-centered").removeClass("edge-y-4"); $activeBox.find(".is-box-centered").addClass("edge-y-3") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-5")) { $activeBox.find(".is-box-centered").removeClass("edge-y-5"); $activeBox.find(".is-box-centered").addClass("edge-y-4") }
                    else { $activeBox.find(".is-box-centered").addClass("edge-y-0"); }
                }
                if (s == "+") {
                    if ($activeBox.find(".is-box-centered").hasClass("edge-y--5")) { $activeBox.find(".is-box-centered").removeClass("edge-y--5"); $activeBox.find(".is-box-centered").addClass("edge-y--4") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--4")) { $activeBox.find(".is-box-centered").removeClass("edge-y--4"); $activeBox.find(".is-box-centered").addClass("edge-y--3") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--3")) { $activeBox.find(".is-box-centered").removeClass("edge-y--3"); $activeBox.find(".is-box-centered").addClass("edge-y--2") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--2")) { $activeBox.find(".is-box-centered").removeClass("edge-y--2"); $activeBox.find(".is-box-centered").addClass("edge-y--1") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y--1")) { $activeBox.find(".is-box-centered").removeClass("edge-y--1"); $activeBox.find(".is-box-centered").addClass("edge-y-0") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-0")) { $activeBox.find(".is-box-centered").removeClass("edge-y-0"); $activeBox.find(".is-box-centered").addClass("edge-y-1") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-1")) { $activeBox.find(".is-box-centered").removeClass("edge-y-1"); $activeBox.find(".is-box-centered").addClass("edge-y-2") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-2")) { $activeBox.find(".is-box-centered").removeClass("edge-y-2"); $activeBox.find(".is-box-centered").addClass("edge-y-3") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-3")) { $activeBox.find(".is-box-centered").removeClass("edge-y-3"); $activeBox.find(".is-box-centered").addClass("edge-y-4") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-4")) { $activeBox.find(".is-box-centered").removeClass("edge-y-4"); $activeBox.find(".is-box-centered").addClass("edge-y-5") }
                    else if ($activeBox.find(".is-box-centered").hasClass("edge-y-5")) { return false; }
                    else { $activeBox.find(".is-box-centered").addClass("edge-y-0") }
                }
                if (s == "") {
                    $activeBox.find(".is-box-centered").removeClass("edge-y--5");
                    $activeBox.find(".is-box-centered").removeClass("edge-y--4");
                    $activeBox.find(".is-box-centered").removeClass("edge-y--3");
                    $activeBox.find(".is-box-centered").removeClass("edge-y--2");
                    $activeBox.find(".is-box-centered").removeClass("edge-y--1");
                    $activeBox.find(".is-box-centered").removeClass("edge-y-0");
                    $activeBox.find(".is-box-centered").removeClass("edge-y-1");
                    $activeBox.find(".is-box-centered").removeClass("edge-y-2");
                    $activeBox.find(".is-box-centered").removeClass("edge-y-3");
                    $activeBox.find(".is-box-centered").removeClass("edge-y-4");
                    $activeBox.find(".is-box-centered").removeClass("edge-y-5");
                }

                //simplified
                if (s == "-") {
                    if ($activeBox.hasClass("edge-y--5")) { return false; }
                    else if ($activeBox.hasClass("edge-y--4")) { $activeBox.removeClass("edge-y--4"); $activeBox.addClass("edge-y--5") }
                    else if ($activeBox.hasClass("edge-y--3")) { $activeBox.removeClass("edge-y--3"); $activeBox.addClass("edge-y--4") }
                    else if ($activeBox.hasClass("edge-y--2")) { $activeBox.removeClass("edge-y--2"); $activeBox.addClass("edge-y--3") }
                    else if ($activeBox.hasClass("edge-y--1")) { $activeBox.removeClass("edge-y--1"); $activeBox.addClass("edge-y--2") }
                    else if ($activeBox.hasClass("edge-y-0")) { $activeBox.removeClass("edge-y-0"); $activeBox.addClass("edge-y--1"); }
                    else if ($activeBox.hasClass("edge-y-1")) { $activeBox.removeClass("edge-y-1"); $activeBox.addClass("edge-y-0"); }
                    else if ($activeBox.hasClass("edge-y-2")) { $activeBox.removeClass("edge-y-2"); $activeBox.addClass("edge-y-1") }
                    else if ($activeBox.hasClass("edge-y-3")) { $activeBox.removeClass("edge-y-3"); $activeBox.addClass("edge-y-2") }
                    else if ($activeBox.hasClass("edge-y-4")) { $activeBox.removeClass("edge-y-4"); $activeBox.addClass("edge-y-3") }
                    else if ($activeBox.hasClass("edge-y-5")) { $activeBox.removeClass("edge-y-5"); $activeBox.addClass("edge-y-4") }
                    else { $activeBox.addClass("edge-y-0"); }
                }
                if (s == "+") {
                    if ($activeBox.hasClass("edge-y--5")) { $activeBox.removeClass("edge-y--5"); $activeBox.addClass("edge-y--4") }
                    else if ($activeBox.hasClass("edge-y--4")) { $activeBox.removeClass("edge-y--4"); $activeBox.addClass("edge-y--3") }
                    else if ($activeBox.hasClass("edge-y--3")) { $activeBox.removeClass("edge-y--3"); $activeBox.addClass("edge-y--2") }
                    else if ($activeBox.hasClass("edge-y--2")) { $activeBox.removeClass("edge-y--2"); $activeBox.addClass("edge-y--1") }
                    else if ($activeBox.hasClass("edge-y--1")) { $activeBox.removeClass("edge-y--1"); $activeBox.addClass("edge-y-0") }
                    else if ($activeBox.hasClass("edge-y-0")) { $activeBox.removeClass("edge-y-0"); $activeBox.addClass("edge-y-1") }
                    else if ($activeBox.hasClass("edge-y-1")) { $activeBox.removeClass("edge-y-1"); $activeBox.addClass("edge-y-2") }
                    else if ($activeBox.hasClass("edge-y-2")) { $activeBox.removeClass("edge-y-2"); $activeBox.addClass("edge-y-3") }
                    else if ($activeBox.hasClass("edge-y-3")) { $activeBox.removeClass("edge-y-3"); $activeBox.addClass("edge-y-4") }
                    else if ($activeBox.hasClass("edge-y-4")) { $activeBox.removeClass("edge-y-4"); $activeBox.addClass("edge-y-5") }
                    else if ($activeBox.hasClass("edge-y-5")) { return false; }
                    else { $activeBox.addClass("edge-y-0") }
                }
                if (s == "") {
                    $activeBox.removeClass("edge-y--5");
                    $activeBox.removeClass("edge-y--4");
                    $activeBox.removeClass("edge-y--3");
                    $activeBox.removeClass("edge-y--2");
                    $activeBox.removeClass("edge-y--1");
                    $activeBox.removeClass("edge-y-0");
                    $activeBox.removeClass("edge-y-1");
                    $activeBox.removeClass("edge-y-2");
                    $activeBox.removeClass("edge-y-3");
                    $activeBox.removeClass("edge-y-4");
                    $activeBox.removeClass("edge-y-5");
                }

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            var photoselect = $element.data("contentbox").settings.photoselect;

            jQuery(".cmd-box-pickphoto").unbind("click");
            jQuery(".cmd-box-pickphoto").on('click', function (e) {

                var $modal = jQuery('.is-modal.pickphoto');
                $element.data("contentbox").showModal($modal);

                $modal.not('.is-modal *').off('click');
                $modal.not('.is-modal *').on('click', function (e) {
                    if (jQuery(e.target).hasClass('is-modal')) {
                        $element.data("contentbox").hideModal($modal);
                    }
                });

                $modal.find('iframe').attr('src', $element.data('contentbox').settings.photoselect); //load module panel on iframe

                return false;
            });

            //Background Color
            jQuery(".cmd-box-pickbgcolor").unbind("click");
            jQuery(".cmd-box-pickbgcolor").on('click', function (e) {

                _fb.saveForUndo(true); // checkLater = true

                colorpicker.open(function(s){

                    $activeBox.css("background-image", "");

                    jQuery('#inpBoxBgColor').val(s);

                    if ($activeBox.find(".is-overlay").length > 0) {
                        var $overlay = $activeBox.find(".is-overlay");
                        if ($overlay.find(".is-overlay-bg").length > 0) {
                            $overlay.data("bg-url", $overlay.find(".is-overlay-bg").css("background-image")); //Save bg image so that it can be restored using "Default" button.
                            $overlay.find(".is-overlay-bg").remove(); //Remove bg image
                            $overlay.find(".is-overlay-color").remove(); //Remove overlay color
                        }
                    }

                    $activeBox.removeClass("is-bg-light");
                    $activeBox.removeClass("is-bg-grey");
                    $activeBox.removeClass("is-bg-dark");

                    $activeBox.css("background-color", s);

                }, jQuery('#inpBoxBgColor').val());

            });

            //Background Gradient
            jQuery(".cmd-box-gradient").unbind("click");
            jQuery(".cmd-box-gradient").on('click', function (e) {

                _fb.saveForUndo(true); // checkLater = true

                var gradientPicker = _fb.gradientpicker();
                gradientPicker.open($activeBox.get(0), function(gradient, textcolor) {

                    if(gradient!='') {

                        if ($activeBox.find(".is-overlay").length > 0) {
                            var $overlay = $activeBox.find(".is-overlay");
                            if ($overlay.find(".is-overlay-bg").length > 0) {
                                $overlay.data("bg-url", $overlay.find(".is-overlay-bg").css("background-image")); //Save bg image so that it can be restored using "Default" button.
                                $overlay.find(".is-overlay-bg").remove(); //Remove bg image
                                $overlay.find(".is-overlay-color").remove(); //Remove overlay color
                            }
                        }

                        $activeBox.css("background-color", '');

                        if (textcolor) $element.data("contentbox").boxTextColor(textcolor);

                    } else {

                        //return to bg image (if any)
                        var $overlay = $activeBox.find(".is-overlay");
                        if ($activeBox.find(".is-overlay-content .is-module").length == 0) {//If not is module
                            if ($overlay.data("bg-url")) {
                                $overlay.find(".is-overlay-bg").remove(); //cleanup from old version (there can be is-overlay-bg with display:none)
                                $overlay.find(".is-overlay-color").remove(); //cleanup from old version (there can be is-overlay-color with display:none)
                                //$overlay.prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
                                //$overlay.prepend('<div class="is-overlay-bg"></div>');
                                $overlay.prepend('<div class="is-overlay-bg" style="transform:scale(1.05)" data-bottom-top="transform:translateY(-120px) scale(1.05);" data-top-bottom="transform:translateY(120px) scale(1.05)"></div>');
                                $overlay.find(".is-overlay-bg").prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
                                $overlay.find(".is-overlay-bg").css("background-image", $overlay.data("bg-url"));
                                //$overlay.removeAttr("data-bg-url");
                                $overlay.removeData("bg-url");
                            }
                        }

                        $activeBox.css("background-image", "");

                        $element.data("contentbox").boxTextColor('');

                    }

                }, function(isChanged){

                });

            });
            //End Background Gradient

            jQuery(".cmd-box-pickoverlaycolor").unbind("click");
            jQuery(".cmd-box-pickoverlaycolor").on('click', function (e) {

                _fb.saveForUndo(true); // checkLater = true

                colorpicker.open(function(s){

                    $element.data("contentbox").boxOverlayColor(s);

                }, '');

            });

            jQuery("#chkBgModule").unbind("click");
            jQuery("#chkBgModule").on('click', function (e) {
                $element.data("contentbox").boxModule();
            });

            jQuery(".cmd-box-textcolor").unbind("click");
            jQuery(".cmd-box-textcolor").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxTextColor(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-bg-img-x").unbind("click");
            jQuery(".cmd-bg-img-x").on('click', function (e) {

                _fb.saveForUndo();

                var s = jQuery(this).data("value");
                var bgpos = $activeBox.find(".is-overlay-bg").css("background-position").split(" ");
                if (s == "-") {
                    var bgposx = bgpos[0].replace("%", "") * 1;
                    if (bgposx > 0) {
                        bgposx = bgposx - 10;
                    }
                }
                if (s == "+") {
                    var bgposx = bgpos[0].replace("%", "") * 1;
                    if (bgposx < 100) {
                        bgposx = bgposx + 10;
                    }
                }
                if (s == "") {
                    var bgposx = 50;
                }
                var bgposy = bgpos[1].replace("%", "") * 1;

                $activeBox.find(".is-overlay-bg").css("background-position", bgposx + "%" + " " + bgposy + "%");

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-bg-img-y").unbind("click");
            jQuery(".cmd-bg-img-y").on('click', function (e) {

                _fb.saveForUndo();

                var s = jQuery(this).data("value");
                var bgpos = $activeBox.find(".is-overlay-bg").css("background-position").split(" ");
                if (s == "-") {
                    var bgposy = bgpos[1].replace("%", "") * 1;
                    if (bgposy > 0) {
                        bgposy = bgposy - 10;
                    }
                }
                if (s == "+") {
                    var bgposy = bgpos[1].replace("%", "") * 1;
                    if (bgposy < 100) {
                        bgposy = bgposy + 10;
                    }
                }
                if (s == "") {
                    var bgposy = 60;
                }
                var bgposx = bgpos[0].replace("%", "") * 1;

                $activeBox.find(".is-overlay-bg").css("background-position", bgposx + "%" + " " + bgposy + "%");

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });


            jQuery("#chkAnimateBg").unbind("click");
            jQuery("#chkAnimateBg").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxAnimateBg();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

            });

            jQuery("#chkParallaxBg").unbind("click");
            jQuery("#chkParallaxBg").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxParallaxBg();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

            });

            jQuery(".cmd-box-overlaycolor").unbind("click");
            jQuery(".cmd-box-overlaycolor").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxOverlayColor(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            jQuery(".cmd-box-overlayopacity").unbind("click");
            jQuery(".cmd-box-overlayopacity").on('click', function (e) {

                _fb.saveForUndo();

                $element.data("contentbox").boxOverlayOpacity(jQuery(this).data("value"));

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

            //added by jack
            jQuery(".cmd-box-selectasset").unbind("click");
            jQuery(".cmd-box-selectasset").on('click', function (e) {
                $element.data("contentbox").boxSelectAsset();
                return false;
            });
            //end of added by jack

            /* Animate Box */
            jQuery('.cmd-box-animate').val('');
            if ($activeBox.hasClass('is-pulse')) jQuery('.cmd-box-animate').val('is-pulse');
            if ($activeBox.hasClass('is-bounceIn')) jQuery('.cmd-box-animate').val('is-bounceIn');
            if ($activeBox.hasClass('is-fadeIn')) jQuery('.cmd-box-animate').val('is-fadeIn');
            if ($activeBox.hasClass('is-fadeInDown')) jQuery('.cmd-box-animate').val('is-fadeInDown');
            if ($activeBox.hasClass('is-fadeInLeft')) jQuery('.cmd-box-animate').val('is-fadeInLeft');
            if ($activeBox.hasClass('is-fadeInRight')) jQuery('.cmd-box-animate').val('is-fadeInRight');
            if ($activeBox.hasClass('is-fadeInUp')) jQuery('.cmd-box-animate').val('is-fadeInUp');
            if ($activeBox.hasClass('is-flipInX')) jQuery('.cmd-box-animate').val('is-flipInX');
            if ($activeBox.hasClass('is-flipInY')) jQuery('.cmd-box-animate').val('is-flipInY');
            if ($activeBox.hasClass('is-slideInUp')) jQuery('.cmd-box-animate').val('is-slideInUp');
            if ($activeBox.hasClass('is-slideInDown')) jQuery('.cmd-box-animate').val('is-slideInDown');
            if ($activeBox.hasClass('is-slideInLeft')) jQuery('.cmd-box-animate').val('is-slideInLeft');
            if ($activeBox.hasClass('is-slideInRight')) jQuery('.cmd-box-animate').val('is-slideInRight');
            if ($activeBox.hasClass('is-zoomIn')) jQuery('.cmd-box-animate').val('is-zoomIn');

            jQuery('.cmd-box-animate').unbind('change');
            jQuery('.cmd-box-animate').change(function (e) {

                _fb.saveForUndo();

                $activeBox.removeClass('is-animated');
                $activeBox.removeClass('is-pulse');
                $activeBox.removeClass('is-bounceIn');
                $activeBox.removeClass('is-fadeIn');
                $activeBox.removeClass('is-fadeInDown');
                $activeBox.removeClass('is-fadeInLeft');
                $activeBox.removeClass('is-fadeInRight');
                $activeBox.removeClass('is-fadeInUp');
                $activeBox.removeClass('is-flipInX');
                $activeBox.removeClass('is-flipInY');
                $activeBox.removeClass('is-slideInUp');
                $activeBox.removeClass('is-slideInDown');
                $activeBox.removeClass('is-slideInLeft');
                $activeBox.removeClass('is-slideInRight');
                $activeBox.removeClass('is-zoomIn');

                $activeBox.removeClass('animated');
                $activeBox.removeClass('pulse');
                $activeBox.removeClass('bounceIn');
                $activeBox.removeClass('fadeIn');
                $activeBox.removeClass('fadeInDown');
                $activeBox.removeClass('fadeInLeft');
                $activeBox.removeClass('fadeInRight');
                $activeBox.removeClass('fadeInUp');
                $activeBox.removeClass('flipInX');
                $activeBox.removeClass('flipInY');
                $activeBox.removeClass('slideInUp');
                $activeBox.removeClass('slideInDown');
                $activeBox.removeClass('slideInLeft');
                $activeBox.removeClass('slideInRight');
                $activeBox.removeClass('zoomIn');

                if (jQuery(this).val() != '') {
                    $activeBox.addClass('is-animated');
                    $activeBox.addClass(jQuery(this).val());

                    $activeBox.addClass('animated');
                    $activeBox.addClass(jQuery(this).val().substr(3));

                    $activeBox.removeClass('box-active'); //need this to make animation work
                }

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                e.preventDefault();
                e.stopImmediatePropagation();
            });

            jQuery('.cmd-box-animate-test').off('click');
            jQuery('.cmd-box-animate-test').on('click', function (e) {

                $activeBox.removeClass('animated');
                $activeBox.removeClass('pulse');
                $activeBox.removeClass('bounceIn');
                $activeBox.removeClass('fadeIn');
                $activeBox.removeClass('fadeInDown');
                $activeBox.removeClass('fadeInLeft');
                $activeBox.removeClass('fadeInRight');
                $activeBox.removeClass('fadeInUp');
                $activeBox.removeClass('flipInX');
                $activeBox.removeClass('flipInY');
                $activeBox.removeClass('slideInUp');
                $activeBox.removeClass('slideInDown');
                $activeBox.removeClass('slideInLeft');
                $activeBox.removeClass('slideInRight');
                $activeBox.removeClass('zoomIn');

                setTimeout(function () {
                    $activeBox.addClass('animated');
                    $activeBox.addClass(jQuery('.cmd-box-animate').val().substr(3));

                    $activeBox.removeClass('box-active'); //need this to make animation work
                }, 50);

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                e.preventDefault();
                e.stopImmediatePropagation();
            });

            if ($activeBox.hasClass('once')) {
                jQuery('#chkAnimOnce').prop("checked", true);
            } else {
                jQuery('#chkAnimOnce').prop("checked", false);
            }
            jQuery('#chkAnimOnce').off('click');
            jQuery('#chkAnimOnce').on('click', function (e) {

                _fb.saveForUndo();

                $activeBox.data('animated', '');
                if (jQuery("#chkAnimOnce").prop("checked")) {
                    $activeBox.addClass('once');
                } else {
                    $activeBox.removeClass('once');
                }

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

            });

            if ($activeBox.hasClass('delay-0ms')) jQuery('.cmd-box-animatedelay').val('delay-0ms');
            if ($activeBox.hasClass('delay-100ms')) jQuery('.cmd-box-animatedelay').val('delay-100ms');
            if ($activeBox.hasClass('delay-200ms')) jQuery('.cmd-box-animatedelay').val('delay-20ms');
            if ($activeBox.hasClass('delay-300ms')) jQuery('.cmd-box-animatedelay').val('delay-300ms');
            if ($activeBox.hasClass('delay-400ms')) jQuery('.cmd-box-animatedelay').val('delay-400ms');
            if ($activeBox.hasClass('delay-500ms')) jQuery('.cmd-box-animatedelay').val('delay-500ms');
            if ($activeBox.hasClass('delay-600ms')) jQuery('.cmd-box-animatedelay').val('delay-600ms');
            if ($activeBox.hasClass('delay-700ms')) jQuery('.cmd-box-animatedelay').val('delay-700ms');
            if ($activeBox.hasClass('delay-800ms')) jQuery('.cmd-box-animatedelay').val('delay-800ms');
            if ($activeBox.hasClass('delay-900ms')) jQuery('.cmd-box-animatedelay').val('delay-900ms');
            if ($activeBox.hasClass('delay-1000ms')) jQuery('.cmd-box-animatedelay').val('delay-1000ms');
            if ($activeBox.hasClass('delay-1100ms')) jQuery('.cmd-box-animatedelay').val('delay-1100ms');
            if ($activeBox.hasClass('delay-1200ms')) jQuery('.cmd-box-animatedelay').val('delay-1200ms');
            if ($activeBox.hasClass('delay-1300ms')) jQuery('.cmd-box-animatedelay').val('delay-1300ms');
            if ($activeBox.hasClass('delay-1400ms')) jQuery('.cmd-box-animatedelay').val('delay-1400ms');
            if ($activeBox.hasClass('delay-1500ms')) jQuery('.cmd-box-animatedelay').val('delay-1500ms');
            if ($activeBox.hasClass('delay-1600ms')) jQuery('.cmd-box-animatedelay').val('delay-1600ms');
            if ($activeBox.hasClass('delay-1700ms')) jQuery('.cmd-box-animatedelay').val('delay-1700ms');
            if ($activeBox.hasClass('delay-1800ms')) jQuery('.cmd-box-animatedelay').val('delay-1800ms');
            if ($activeBox.hasClass('delay-1900ms')) jQuery('.cmd-box-animatedelay').val('delay-1900ms');
            if ($activeBox.hasClass('delay-2000ms')) jQuery('.cmd-box-animatedelay').val('delay-2000ms');
            if ($activeBox.hasClass('delay-2100ms')) jQuery('.cmd-box-animatedelay').val('delay-2100ms');
            if ($activeBox.hasClass('delay-2200ms')) jQuery('.cmd-box-animatedelay').val('delay-2200ms');
            if ($activeBox.hasClass('delay-2300ms')) jQuery('.cmd-box-animatedelay').val('delay-2300ms');
            if ($activeBox.hasClass('delay-2400ms')) jQuery('.cmd-box-animatedelay').val('delay-2400ms');
            if ($activeBox.hasClass('delay-2500ms')) jQuery('.cmd-box-animatedelay').val('delay-2500ms');
            if ($activeBox.hasClass('delay-2600ms')) jQuery('.cmd-box-animatedelay').val('delay-2600ms');
            if ($activeBox.hasClass('delay-2700ms')) jQuery('.cmd-box-animatedelay').val('delay-2700ms');
            if ($activeBox.hasClass('delay-2800ms')) jQuery('.cmd-box-animatedelay').val('delay-2800ms');
            if ($activeBox.hasClass('delay-2900ms')) jQuery('.cmd-box-animatedelay').val('delay-2900ms');
            if ($activeBox.hasClass('delay-3000ms')) jQuery('.cmd-box-animatedelay').val('delay-3000ms');

            jQuery('.cmd-box-animatedelay').unbind('change');
            jQuery('.cmd-box-animatedelay').change(function (e) {

                _fb.saveForUndo();

                $activeBox.removeClass('delay-0ms');
                $activeBox.removeClass('delay-100ms');
                $activeBox.removeClass('delay-200ms');
                $activeBox.removeClass('delay-300ms');
                $activeBox.removeClass('delay-400ms');
                $activeBox.removeClass('delay-500ms');
                $activeBox.removeClass('delay-600ms');
                $activeBox.removeClass('delay-700ms');
                $activeBox.removeClass('delay-800ms');
                $activeBox.removeClass('delay-900ms');
                $activeBox.removeClass('delay-1000ms');
                $activeBox.removeClass('delay-1100ms');
                $activeBox.removeClass('delay-1200ms');
                $activeBox.removeClass('delay-1300ms');
                $activeBox.removeClass('delay-1400ms');
                $activeBox.removeClass('delay-1500ms');
                $activeBox.removeClass('delay-1600ms');
                $activeBox.removeClass('delay-1700ms');
                $activeBox.removeClass('delay-1800ms');
                $activeBox.removeClass('delay-1900ms');
                $activeBox.removeClass('delay-2000ms');
                $activeBox.removeClass('delay-2100ms');
                $activeBox.removeClass('delay-2200ms');
                $activeBox.removeClass('delay-2300ms');
                $activeBox.removeClass('delay-2400ms');
                $activeBox.removeClass('delay-2500ms');
                $activeBox.removeClass('delay-2600ms');
                $activeBox.removeClass('delay-2700ms');
                $activeBox.removeClass('delay-2800ms');
                $activeBox.removeClass('delay-2900ms');
                $activeBox.removeClass('delay-3000ms');

                if (jQuery(this).val() != '') {
                    $activeBox.addClass(jQuery(this).val());
                }

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                e.preventDefault();
                e.stopImmediatePropagation();
            });

            /* /Animate Box */


            jQuery("#inpBoxHtml").val(jQuery.trim($activeBox.html()));
            jQuery(".cmd-box-html").unbind("click");
            jQuery(".cmd-box-html").on('click', function (e) {

                _fb.saveForUndo();

                $activeBox.html(jQuery("#inpBoxHtml").val());

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                return false;
            });

        };

        this.boxWidth = function (n) {
            $activeBox.find(".is-container").css("max-width", "");
            $activeBox.find(".is-container").removeClass("is-content-380");
            $activeBox.find(".is-container").removeClass("is-content-500");
            $activeBox.find(".is-container").removeClass("is-content-640");
            $activeBox.find(".is-container").removeClass("is-content-800");
            $activeBox.find(".is-container").removeClass("is-content-970"); //backward
            $activeBox.find(".is-container").removeClass("is-content-980");
            $activeBox.find(".is-container").removeClass("is-content-1050");
            $activeBox.find(".is-container").removeClass("is-content-1100");
            $activeBox.find(".is-container").removeClass("is-content-1200");

            if (n != 0) {
                $activeBox.find(".is-container").addClass("is-content-" + n);
            }
            return false;
        };

        this.boxBgColor = function (s) {

            $activeBox.css("background-color", "");
            $activeBox.css("background-image", "");

            var $overlay = $activeBox.find(".is-overlay");

            if (s == "") {
                //Default button (no color, show bg image)

                if ($activeBox.find(".is-overlay-content .is-module").length == 0) {//If not is module
                    if ($overlay.data("bg-url")) {
                        $overlay.find(".is-overlay-bg").remove(); //cleanup from old version (there can be is-overlay-bg with display:none)
                        $overlay.find(".is-overlay-color").remove(); //cleanup from old version (there can be is-overlay-color with display:none)
                        //$overlay.prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
                        //$overlay.prepend('<div class="is-overlay-bg"></div>');
                        $overlay.prepend('<div class="is-overlay-bg" style="transform:scale(1.05)" data-bottom-top="transform:translateY(-120px) scale(1.05);" data-top-bottom="transform:translateY(120px) scale(1.05)"></div>');
                        $overlay.find(".is-overlay-bg").prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
                        $overlay.find(".is-overlay-bg").css("background-image", $overlay.data("bg-url"));
                        //$overlay.removeAttr("data-bg-url");
                        $overlay.removeData("bg-url");
                    }
                }

                $activeBox.removeClass("is-bg-light");
                $activeBox.removeClass("is-bg-grey");
                $activeBox.removeClass("is-bg-dark");

                $element.data("contentbox").boxTextColor("");
            } else {
                //Apply bg color

                $overlay.data("bg-url", $overlay.find(".is-overlay-bg").css("background-image")); //Save bg image so that it can be restored using "Default" button.
                $overlay.find(".is-overlay-bg").remove(); //Remove bg image
                $overlay.find(".is-overlay-color").remove(); //Remove overlay color

                if (s == "grey") {
                    $activeBox.removeClass("is-bg-dark");
                    $activeBox.removeClass("is-bg-light");
                    $activeBox.addClass("is-bg-grey");

                    $element.data("contentbox").boxTextColor("dark");
                }
                if (s == "dark") {
                    $activeBox.removeClass("is-bg-grey");
                    $activeBox.removeClass("is-bg-light");
                    $activeBox.addClass("is-bg-dark");

                    $element.data("contentbox").boxTextColor("light");
                }
                if (s == "light") {
                    $activeBox.removeClass("is-bg-grey");
                    $activeBox.removeClass("is-bg-dark");
                    $activeBox.addClass("is-bg-light");

                    $element.data("contentbox").boxTextColor("dark");
                }
            }

            return false;
        };

        this.boxModule = function (s) {
            var $overlay = $activeBox.find(".is-overlay");

            if ($activeBox.find(".is-overlay").length == 0) {
                $activeBox.prepend('<div class="is-overlay"></div>');
            }
            var $overlay = $activeBox.find(".is-overlay");
            if ($overlay.find(".is-overlay-content").length == 0) {
                $overlay.append('<div class="is-overlay-content"></div>');
            }

            if (jQuery("#chkBgModule").prop("checked")) {
                $overlay.find(".is-overlay-content").html("<div class='is-module'></div>"); //[%BREAK%]

                jQuery("#divBoxBackgroundColor").css("display", "block"); //show Background settings

                $overlay.find(".is-overlay-bg").remove();
                $overlay.find(".is-overlay-color").remove();
                $overlay.data("bg-url", $overlay.find(".is-overlay-bg").css("background-image"));
            } else {
                $overlay.find(".is-overlay-content").remove();

                if ($activeBox.find(".is-container").length > 0) {
                    jQuery("#divBoxBackgroundColor").css("display", "block"); //show Background settings
                } else {
                    jQuery("#divBoxBackgroundColor").css("display", "none");
                }

                //$overlay.find(".is-overlay-bg").css("display", "block");
            }
        };

        this.boxTextColor = function (s) {
            if (s == "light") {
                $activeBox.removeClass("is-dark-text");
                $activeBox.addClass("is-light-text");
            }
            if (s == "dark") {
                $activeBox.removeClass("is-light-text");
                $activeBox.addClass("is-dark-text");
            }
            if (s == "") {
                $activeBox.removeClass("is-dark-text");
                $activeBox.removeClass("is-light-text");
            }
            return false;
        };

        this.boxTextAlign = function (s) {
            $activeBox.find(".center").removeClass("center");
            $activeBox.find(".is-builder > div > div > *").css("text-align", "");
            if (s == "right") {
                $activeBox.removeClass("is-align-left");
                $activeBox.removeClass("is-align-center");
                $activeBox.removeClass("is-align-justify");
                $activeBox.addClass("is-align-right");
            }
            if (s == "center") {
                $activeBox.removeClass("is-align-left");
                $activeBox.removeClass("is-align-right");
                $activeBox.removeClass("is-align-justify");
                $activeBox.addClass("is-align-center");
            }
            if (s == "left") {
                $activeBox.removeClass("is-align-right");
                $activeBox.removeClass("is-align-center");
                $activeBox.removeClass("is-align-justify");
                $activeBox.addClass("is-align-left");
            }
            if (s == "justify") {
                $activeBox.removeClass("is-align-left");
                $activeBox.removeClass("is-align-right");
                $activeBox.removeClass("is-align-center");
                $activeBox.addClass("is-align-justify");
            }
            return false;
        };

        this.boxTextOpacity = function (s) {
            var $cb = $activeBox.find(".is-box-centered");

            if (s == "+") {
                if ($cb.hasClass("is-opacity-20")) { $cb.removeClass("is-opacity-20"); $cb.addClass("is-opacity-25") }
                else if ($cb.hasClass("is-opacity-25")) { $cb.removeClass("is-opacity-25"); $cb.addClass("is-opacity-30") }
                else if ($cb.hasClass("is-opacity-30")) { $cb.removeClass("is-opacity-30"); $cb.addClass("is-opacity-35") }
                else if ($cb.hasClass("is-opacity-35")) { $cb.removeClass("is-opacity-35"); $cb.addClass("is-opacity-40") }
                else if ($cb.hasClass("is-opacity-40")) { $cb.removeClass("is-opacity-40"); $cb.addClass("is-opacity-45") }
                else if ($cb.hasClass("is-opacity-45")) { $cb.removeClass("is-opacity-45"); $cb.addClass("is-opacity-50") }
                else if ($cb.hasClass("is-opacity-50")) { $cb.removeClass("is-opacity-50"); $cb.addClass("is-opacity-55") }
                else if ($cb.hasClass("is-opacity-55")) { $cb.removeClass("is-opacity-55"); $cb.addClass("is-opacity-60") }
                else if ($cb.hasClass("is-opacity-60")) { $cb.removeClass("is-opacity-60"); $cb.addClass("is-opacity-65") }
                else if ($cb.hasClass("is-opacity-65")) { $cb.removeClass("is-opacity-65"); $cb.addClass("is-opacity-70") }
                else if ($cb.hasClass("is-opacity-70")) { $cb.removeClass("is-opacity-70"); $cb.addClass("is-opacity-75") }
                else if ($cb.hasClass("is-opacity-75")) { $cb.removeClass("is-opacity-75"); $cb.addClass("is-opacity-80") }
                else if ($cb.hasClass("is-opacity-80")) { $cb.removeClass("is-opacity-80"); $cb.addClass("is-opacity-85") }
                else if ($cb.hasClass("is-opacity-85")) { $cb.removeClass("is-opacity-85"); $cb.addClass("is-opacity-90") }
                else if ($cb.hasClass("is-opacity-90")) { $cb.removeClass("is-opacity-90"); $cb.addClass("is-opacity-95") }
                else if ($cb.hasClass("is-opacity-95")) { $cb.removeClass("is-opacity-95"); }
                return false;
            }
            if (s == "-") {
                if ($cb.hasClass("is-opacity-20")) { return false; }
                else if ($cb.hasClass("is-opacity-25")) { $cb.removeClass("is-opacity-25"); $cb.addClass("is-opacity-20") }
                else if ($cb.hasClass("is-opacity-30")) { $cb.removeClass("is-opacity-30"); $cb.addClass("is-opacity-25") }
                else if ($cb.hasClass("is-opacity-35")) { $cb.removeClass("is-opacity-35"); $cb.addClass("is-opacity-30") }
                else if ($cb.hasClass("is-opacity-40")) { $cb.removeClass("is-opacity-40"); $cb.addClass("is-opacity-35") }
                else if ($cb.hasClass("is-opacity-45")) { $cb.removeClass("is-opacity-45"); $cb.addClass("is-opacity-40") }
                else if ($cb.hasClass("is-opacity-50")) { $cb.removeClass("is-opacity-50"); $cb.addClass("is-opacity-45") }
                else if ($cb.hasClass("is-opacity-55")) { $cb.removeClass("is-opacity-55"); $cb.addClass("is-opacity-50") }
                else if ($cb.hasClass("is-opacity-60")) { $cb.removeClass("is-opacity-60"); $cb.addClass("is-opacity-55") }
                else if ($cb.hasClass("is-opacity-65")) { $cb.removeClass("is-opacity-65"); $cb.addClass("is-opacity-60") }
                else if ($cb.hasClass("is-opacity-70")) { $cb.removeClass("is-opacity-70"); $cb.addClass("is-opacity-65") }
                else if ($cb.hasClass("is-opacity-75")) { $cb.removeClass("is-opacity-75"); $cb.addClass("is-opacity-70") }
                else if ($cb.hasClass("is-opacity-80")) { $cb.removeClass("is-opacity-80"); $cb.addClass("is-opacity-75") }
                else if ($cb.hasClass("is-opacity-85")) { $cb.removeClass("is-opacity-85"); $cb.addClass("is-opacity-80") }
                else if ($cb.hasClass("is-opacity-90")) { $cb.removeClass("is-opacity-90"); $cb.addClass("is-opacity-85") }
                else if ($cb.hasClass("is-opacity-95")) { $cb.removeClass("is-opacity-95"); $cb.addClass("is-opacity-90") }
                else { $cb.addClass("is-opacity-95") }
                return false;
            }

            $cb.removeClass("is-opacity-20");
            $cb.removeClass("is-opacity-25");
            $cb.removeClass("is-opacity-30");
            $cb.removeClass("is-opacity-35");
            $cb.removeClass("is-opacity-40");
            $cb.removeClass("is-opacity-45");
            $cb.removeClass("is-opacity-50");
            $cb.removeClass("is-opacity-55");
            $cb.removeClass("is-opacity-60");
            $cb.removeClass("is-opacity-65");
            $cb.removeClass("is-opacity-70");
            $cb.removeClass("is-opacity-75");
            $cb.removeClass("is-opacity-80");
            $cb.removeClass("is-opacity-85");
            $cb.removeClass("is-opacity-90");
            $cb.removeClass("is-opacity-95");

            if (s == "0.7") {
                $cb.addClass("is-opacity-70");
            }
            if (s == "0.75") {
                $cb.addClass("is-opacity-75");
            }
            if (s == "0.8") {
                $cb.addClass("is-opacity-80");
            }
            if (s == "0.85") {
                $cb.addClass("is-opacity-85");
            }
            if (s == "0.90") {
                $cb.addClass("is-opacity-90");
            }
            if (s == "0.95") {
                $cb.addClass("is-opacity-95");
            }
            return false;
        };

        this.boxWidthSmaller = function () {
            var $currentBox;
            var $nextBox;

            var ok = false;
            for (i = 1; i <= 12; i++) {
                if ($activeBox.hasClass("is-box-" + i)) {
                    ok = true;
                }
            }
            if (ok) {
                $currentBox = $activeBox;
            } else {
                $currentBox = $activeBox.parent();
            }

            if ($currentBox.next().length > 0) {
                $nextBox = $currentBox.next();
                this.boxMinus($currentBox);
                this.boxPlus($nextBox);
                return false;
            } else if ($currentBox.prev().length > 0) {
                $nextBox = $currentBox.prev();
                this.boxMinus($currentBox);
                this.boxPlus($nextBox);
                return false;
            }
        };

        this.boxWidthLarger = function () {
            var $currentBox;
            var $nextBox;

            var ok = false;
            for (i = 1; i <= 12; i++) {
                if ($activeBox.hasClass("is-box-" + i)) {
                    ok = true;
                }
            }
            if (ok) {
                $currentBox = $activeBox;
            } else {
                $currentBox = $activeBox.parent();
            }


            if ($currentBox.next().length > 0) {
                $nextBox = $currentBox.next();
                this.boxPlus($currentBox);
                this.boxMinus($nextBox);
                return false;
            } else if ($currentBox.prev().length > 0) {
                $nextBox = $currentBox.prev();
                this.boxPlus($currentBox);
                this.boxMinus($nextBox);
                return false;
            }
        };

        this.boxPlus = function ($box) {
            for (i = 1; i < 12; i++) {
                if ($box.hasClass("is-box-" + i)) {
                    $box.removeClass("is-box-" + i);
                    $box.addClass("is-box-" + (i + 1));
                    return;
                }
            }
        };

        this.boxMinus = function ($box) {
            for (i = 12; i > 1; i--) {
                if ($box.hasClass("is-box-" + i)) {
                    $box.removeClass("is-box-" + i);
                    $box.addClass("is-box-" + (i - 1));
                    return;
                }
            }
        };

        this.boxAnimateBg = function () {
            var $overlay = $activeBox.find(".is-overlay");
            if (jQuery("#chkAnimateBg").prop("checked")) {
                $overlay.find(".is-overlay-bg").addClass("is-scale-animated");
                $overlay.find(".is-overlay-bg").addClass("is-appeared");
            } else {
                $overlay.find(".is-overlay-bg").removeClass("is-scale-animated");
                $overlay.find(".is-overlay-bg").removeClass("is-appeared");
            }
        };

        this.boxParallaxBg = function () {
            var $overlay = $activeBox.find(".is-overlay");
            if (jQuery("#chkParallaxBg").prop("checked")) {
                $overlay.find(".is-overlay-bg").attr("data-bottom-top", "transform:translateY(-120px) scale(1.05)");
                $overlay.find(".is-overlay-bg").attr("data-top-bottom", "transform:translateY(120px) scale(1.05)");

                $element.data("contentbox").settings.onRender();
            } else {
                $overlay.find(".is-overlay-bg").removeClass("skrollable");
                $overlay.find(".is-overlay-bg").removeClass("skrollable-between");
                $overlay.find(".is-overlay-bg").removeAttr("data-bottom-top");
                $overlay.find(".is-overlay-bg").removeAttr("data-top-bottom");
                $overlay.find(".is-overlay-bg").css("transform", "translateY(0) scale(1)");
                $overlay.find(".is-overlay-bg").css("transform", "");
                var s = $overlay.find(".is-overlay-bg").get(0).outerHTML;
                $overlay.find(".is-overlay-bg").remove();
                $overlay.append(s);
            }
        };

        this.boxOverlayOpacity = function (s) {
            var $overlay = $activeBox.find(".is-overlay");
            var $overlaycolor = $overlay.find(".is-overlay-color");
            if ($overlaycolor.length == 0) {
                //jQuery('<div class="is-overlay-color" style="opacity:0.1"></div>').insertAfter($overlay.find('.is-overlay-bg'));
                $overlay.find(".is-overlay-bg").prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
                $overlaycolor = $overlay.find(".is-overlay-color");
            }

            if (s == "+") {
                $overlaycolor.css("display", "block");
                if ($overlaycolor.css("opacity") == 0.01) $overlaycolor.css("opacity", 0.025);
                else if ($overlaycolor.css("opacity") == 0.025) $overlaycolor.css("opacity", 0.04);
                else if ($overlaycolor.css("opacity") == 0.04) $overlaycolor.css("opacity", 0.055);
                else if ($overlaycolor.css("opacity") == 0.055) $overlaycolor.css("opacity", 0.07);
                else if ($overlaycolor.css("opacity") == 0.07) $overlaycolor.css("opacity", 0.085);
                else if ($overlaycolor.css("opacity") == 0.085) $overlaycolor.css("opacity", 0.1);
                else if ($overlaycolor.css("opacity") == 0.1) $overlaycolor.css("opacity", 0.125);
                else if ($overlaycolor.css("opacity") == 0.125) $overlaycolor.css("opacity", 0.15);
                else if ($overlaycolor.css("opacity") == 0.15) $overlaycolor.css("opacity", 0.2);
                else if ($overlaycolor.css("opacity") == 0.2) $overlaycolor.css("opacity", 0.25);
                else if ($overlaycolor.css("opacity") == 0.25) $overlaycolor.css("opacity", 0.3);
                else if ($overlaycolor.css("opacity") == 0.3) $overlaycolor.css("opacity", 0.35);
                else if ($overlaycolor.css("opacity") == 0.35) $overlaycolor.css("opacity", 0.4);
                else if ($overlaycolor.css("opacity") == 0.4) $overlaycolor.css("opacity", 0.45);
                else if ($overlaycolor.css("opacity") == 0.45) $overlaycolor.css("opacity", 0.5);
                else if ($overlaycolor.css("opacity") == 0.5) $overlaycolor.css("opacity", 0.55);
                else if ($overlaycolor.css("opacity") == 0.55) $overlaycolor.css("opacity", 0.6);
                else if ($overlaycolor.css("opacity") == 0.6) $overlaycolor.css("opacity", 0.6);
                else $overlaycolor.css("opacity", 0.15);
            }
            if (s == "-") {
                $overlaycolor.css("display", "block");
                if ($overlaycolor.css("opacity") == 0.01) { $overlaycolor.css("opacity", 0.01) }
                else if ($overlaycolor.css("opacity") == 0.025) $overlaycolor.css("opacity", 0.01);
                else if ($overlaycolor.css("opacity") == 0.04) $overlaycolor.css("opacity", 0.025);
                else if ($overlaycolor.css("opacity") == 0.055) $overlaycolor.css("opacity", 0.04);
                else if ($overlaycolor.css("opacity") == 0.07) $overlaycolor.css("opacity", 0.055);
                else if ($overlaycolor.css("opacity") == 0.085) $overlaycolor.css("opacity", 0.07);
                else if ($overlaycolor.css("opacity") == 0.1) $overlaycolor.css("opacity", 0.085);
                else if ($overlaycolor.css("opacity") == 0.125) $overlaycolor.css("opacity", 0.1);
                else if ($overlaycolor.css("opacity") == 0.15) $overlaycolor.css("opacity", 0.125);
                else if ($overlaycolor.css("opacity") == 0.2) $overlaycolor.css("opacity", 0.15);
                else if ($overlaycolor.css("opacity") == 0.25) $overlaycolor.css("opacity", 0.2);
                else if ($overlaycolor.css("opacity") == 0.3) $overlaycolor.css("opacity", 0.25);
                else if ($overlaycolor.css("opacity") == 0.35) $overlaycolor.css("opacity", 0.3);
                else if ($overlaycolor.css("opacity") == 0.4) $overlaycolor.css("opacity", 0.35);
                else if ($overlaycolor.css("opacity") == 0.45) $overlaycolor.css("opacity", 0.4);
                else if ($overlaycolor.css("opacity") == 0.5) $overlaycolor.css("opacity", 0.45);
                else if ($overlaycolor.css("opacity") == 0.55) $overlaycolor.css("opacity", 0.5);
                else if ($overlaycolor.css("opacity") == 0.6) $overlaycolor.css("opacity", 0.55);
                else { $overlaycolor.css("opacity", 0.15) }
            }
            if (s == "0") {
                $overlaycolor.remove();
            }

            return false;
        };

        this.boxOverlayColor = function (s) {
            var $overlay = $activeBox.find(".is-overlay");
            var $overlaycolor = $overlay.find(".is-overlay-color");
            if ($overlaycolor.length == 0) {
                //jQuery('<div class="is-overlay-color" style="opacity:0.1"></div>').insertAfter($overlay.find('.is-overlay-bg'));
                $overlay.find(".is-overlay-bg").prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
                $overlaycolor = $overlay.find(".is-overlay-color");
            }

            if ($overlaycolor.css("display") == "none" || $overlaycolor.css("opacity") == 0) {//backward compatible
                $overlaycolor.css("display", "block");
                $overlaycolor.css("opacity", 0.1);
            }

            if (s == '') {
                $overlaycolor.remove();
            } else {
                $overlaycolor.css("background-color", s);
            }
            return false;
        };

        //added by jack
        this.boxSelectAsset = function () {
            var $overlay = $activeBox.find(".is-overlay");
            var $overlaybg = $overlay.find(".is-overlay-bg");
            if (this.settings.onCoverImageSelectClick) {
                this.settings.onCoverImageSelectClick($overlaybg.get(0));
            }
            return false;
        };
        //end of added by jack

        this.sectionUseScroll = function () {
            if (jQuery("#chkScrollIcon").prop("checked")) {

                var $refSection = $activeSection.find(".is-section-tool");
                jQuery('<div class="is-arrow-down bounce"><a href="#"><i class="icon ion-ios-arrow-thin-down"></i></a></div>').insertBefore($refSection); /* &darr; */

                jQuery('.is-arrow-down a').on('click', function (e) {
                    if (jQuery(this).parents(".is-section").next().html()) {
                        jQuery('html,body').animate({
                            scrollTop: jQuery(this).parents(".is-section").next().offset().top
                        }, 800);
                    }
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                });

            } else {
                $activeSection.find(".is-arrow-down").remove();
            }
            return false;
        };

        this.sectionScrollIcon = function (s) {
            if (s == "light") {
                $activeSection.find(".is-arrow-down").addClass('light');
            } else {
                $activeSection.find(".is-arrow-down").removeClass('light');
            }
            return false;
        };

        this.sectionUp = function () {
            if ($activeSection.prev('.is-section').length > 0 && !$activeSection.prev('.is-section').hasClass('is-static')) {
                var $refSection = $activeSection.prev();
                $activeSection.insertBefore($refSection);

                //Trigger Render event
                this.settings.onRender();

                jQuery('html,body').animate({
                    scrollTop: $activeSection.offset().top
                }, 600);
            }
            return false;
        };

        this.sectionDown = function () {
            if ($activeSection.next('.is-section').length > 0 && !$activeSection.next('.is-section').hasClass('is-static')) {
                var $refSection = $activeSection.next();
                $activeSection.insertAfter($refSection);

                //Trigger Render event
                this.settings.onRender();

                jQuery('html,body').animate({
                    scrollTop: $activeSection.offset().top
                }, 600);
            }
            return false;
        };

        this.sectionTop = function () {
            var $refSection = $element.children('.is-section').not('.is-static').first();
            $activeSection.insertBefore($refSection);

            //Trigger Render event
            this.settings.onRender();

            jQuery('html,body').animate({
                scrollTop: $activeSection.offset().top
            }, 600);
            return false;
        };

        this.sectionBottom = function () {
            var $refSection = $element.children('.is-section').not('.is-static').last();
            $activeSection.insertAfter($refSection);

            //Trigger Render event
            this.settings.onRender();

            jQuery('html,body').animate({
                scrollTop: $activeSection.offset().top
            }, 600);

            return false;
        };

        this.sectionHeight = function (n) {
            $activeSection.css("height", "");
            $activeSection.removeClass("is-section-auto");
            $activeSection.removeClass("is-section-20");
            $activeSection.removeClass("is-section-30");
            $activeSection.removeClass("is-section-40");
            $activeSection.removeClass("is-section-50");
            $activeSection.removeClass("is-section-60");
            $activeSection.removeClass("is-section-75");
            $activeSection.removeClass("is-section-100");

            if (n == 0) {
                $activeSection.addClass("is-section-auto");
            } else {
                $activeSection.addClass("is-section-" + n);
            }

            //Trigger Render event
            this.settings.onRender();

            jQuery('html,body').animate({
                scrollTop: $activeSection.offset().top
            }, 600);
            return false;
        };

        this.mainCss = function () {
            var css = '';

            var links = document.getElementsByTagName("link");
            for (var i = 0; i < links.length; i++) {
                var src = links[i].href.toLowerCase();
                if (src.indexOf('basetype-') != -1) {
                    css += links[i].outerHTML;
                }
            }

            return css;
        };

        this.sectionCss = function () {
            var css = '';

            var links = document.getElementsByTagName("link");
            for (var i = 0; i < links.length; i++) {
                var src = links[i].href.toLowerCase();
                if (src.indexOf('basetype-') != -1) {
                    //noop
                } else if (src.indexOf('type-') != -1) {
                    css += links[i].outerHTML;
                }
            }

            return css;
        };

        var hash = {};
        var hashAttr = {};
        var hashSettings = {};

        this.html = function (bForView) {

            cleanupUnused();

            var html = _fb.readHtml($element.get(0), bForView, true);

            return html;

        };

        this.viewHtml = function (s) {

            var html = this.html(true); //For View

            jQuery('#inpViewHtml').val(html);

            //used  textarea from #divSidebarSource
            jQuery('textarea').removeAttr('data-source-active');
            jQuery('textarea').removeAttr('data-source-ok');
            jQuery('textarea').removeAttr('data-source-cancel');
            jQuery('#divSidebarSource textarea').attr('data-source-active', '1');
            jQuery('#divSidebarSource textarea').attr('data-source-ok', '#btnViewHtmlOk');
            jQuery('#divSidebarSource textarea').attr('data-source-cancel', '#btnViewHtmlCancel');

            //_fb.viewHtml(); //OR:
            _fb.viewHtmlNormal();

            jQuery('#btnViewHtmlOk').off('click');
            jQuery('#btnViewHtmlOk').on('click', function (e) {

                _fb.saveForUndo();

                var html = jQuery('#inpViewHtml').val();

                html = _fb.fromViewToActual(html);

                jQuery('.is-wrapper').html(html);

                $element.data("contentbox").setup();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

            });

            jQuery('#btnViewHtmlCancel').off('click');
            jQuery('#btnViewHtmlCancel').bind('click', function (e) {

                // None, because there is no sidebar panel to close

            });

        };

        this.viewHtml2 = function (s) {
            jQuery('body').css('overflow', 'hidden');

            var html = this.html(true); //For View

            jQuery('#inpViewHtml').val(html);

            jQuery('#btnViewHtmlOk').off('click');
            jQuery('#btnViewHtmlOk').on('click', function (e) {

                _fb.saveForUndo();

                /*
                var $htmlEditor = jQuery('#inpViewHtml').data('CodeMirrorInstance');
                jQuery('#inpViewHtml').val($htmlEditor.getValue());
                */

                var html = jQuery('#inpViewHtml').val();

                html = _fb.fromViewToActual(html);

                jQuery('.is-wrapper').html(html);

                $element.data("contentbox").setup();

                //Trigger Change event
                $element.data("contentbox").settings.onChange();

                //Close sidebar
                jQuery('.is-sidebar-overlay').remove();
                jQuery('.is-sidebar > div').removeClass('active');
                jQuery('.is-sidebar-content').removeClass('active');
                jQuery('body').css('overflow', '');

            });

            jQuery('#btnViewHtmlCancel').off('click');
            jQuery('#btnViewHtmlCancel').bind('click', function (e) {

                //Close sidebar
                jQuery('.is-sidebar-overlay').remove();
                jQuery('.is-sidebar > div').removeClass('active');
                jQuery('.is-sidebar-content').removeClass('active');
                jQuery('body').css('overflow', '');

            });

            //Open Larger Editor

            jQuery('#divSidebarSource .edit-html-larger').off('click');
            jQuery('#divSidebarSource .edit-html-larger').on('click', function (e) {

                //used  by larger editor dialog (html.html)
                jQuery('textarea').removeAttr('data-source-active');
                jQuery('textarea').removeAttr('data-source-ok');
                jQuery('textarea').removeAttr('data-source-cancel');
                jQuery('#divSidebarSource textarea').attr('data-source-active', '1');
                jQuery('#divSidebarSource textarea').attr('data-source-ok', '#btnViewHtmlOk');
                jQuery('#divSidebarSource textarea').attr('data-source-cancel', '#btnViewHtmlCancel');

                _fb.viewHtmlLarger();

            });

            return false;
        };

        this.viewTypography = function (s) {

            var contentStylePath = $element.data("contentbox").settings.contentStylePath;
            if (jQuery('#ifrTypographyPanel').attr('src').indexOf('blank') != -1) {
                jQuery('#ifrTypographyPanel').attr('src', contentStylePath + 'browse.html');
            }

            return false;
        };

        this.viewIdeas = function (s) {
            jQuery('body').css('overflow', 'hidden');

            var designPath = $element.data("contentbox").settings.designPath;
            if (jQuery('#ifrIdeasPanel').attr('src').indexOf('blank') != -1) {
                jQuery('#ifrIdeasPanel').attr('src', designPath + 'ideas.html');
            }

            return false;
        };

        this.boxTypography = function (className, contentCss, pageCss) {

            _fb.saveForUndo();

            var contentStylePath = $element.data("contentbox").settings.contentStylePath;

            //Check apply to what
            var applyto = jQuery('.is-sidebar > div[data-command=typography]').attr('data-applyto');

            if (applyto == 'box') {

                if ($activeBox) {
                    var classList = $activeBox.attr('class').split(/\s+/);
                    $.each(classList, function (index, item) {
                        if (item.indexOf('type-') != -1) {//Remove previous class that has prefix 'type-'
                            $activeBox.removeClass(item);
                        }
                    });
                    //Add new class
                    if (className != '') {
                        $activeBox.addClass(className);

                        //Add css
                        var exist = false;
                        var links = document.getElementsByTagName("link");
                        for (var i = 0; i < links.length; i++) {
                            var src = links[i].href.toLowerCase();
                            if (src.indexOf(contentCss.toLowerCase()) != -1) exist = true;
                        }
                        if (!exist) jQuery('head').append('<link data-name="contentstyle" data-class="' + className + '" href="' + contentStylePath + contentCss + '" rel="stylesheet">');
                    }

                    //Cleanup unused
                    var links = document.getElementsByTagName("link");
                    for (var i = 0; i < links.length; i++) {
                        if (jQuery(links[i]).attr('data-name') == 'contentstyle') {

                            var classname = jQuery(links[i]).attr('data-class');

                            //check if classname used in content
                            if (jQuery(".is-wrapper").find('.' + classname).length == 0) {
                                jQuery(links[i]).attr('data-rel', '_del');
                            }

                        }
                    }
                    jQuery('[data-rel="_del"]').remove();

                }

            } else {

                var bSectionStyleExists = false;
                var links = document.getElementsByTagName("link");
                for (var i = 0; i < links.length; i++) {
                    if (jQuery(links[i]).attr('data-name') == 'contentstyle') {
                        bSectionStyleExists = true;
                    }
                }

                if (!bSectionStyleExists) {

                    //Cleanup (remove previous css that has prefix 'basetype-')
                    var links = document.getElementsByTagName("link");
                    for (var i = 0; i < links.length; i++) {
                        var src = links[i].href.toLowerCase();
                        if (src.indexOf('basetype-') != -1) {
                            jQuery(links[i]).attr('data-rel', '_del');
                        }
                    }
                    jQuery('[data-rel="_del"]').remove();

                    //Add new page css
                    if (pageCss != '') {
                        jQuery('head').append('<link href="' + contentStylePath + pageCss + '" rel="stylesheet">');
                    }

                } else {

                    var $modal = jQuery('.is-modal.applytypography');
                    $element.data("contentbox").showModal($modal);

                    $modal.not('.is-modal *').off('click');
                    $modal.not('.is-modal *').on('click', function (e) {
                        if (jQuery(e.target).hasClass('is-modal')) {
                            $element.data("contentbox").hideModal($modal);
                        }
                    });

                    $('input:radio[name=rdoApplyTypoStyle]')[1].checked = true;

                    $modal.find('.input-ok').off('click');
                    $modal.find('.input-ok').on('click', function (e) {

                        var val = $('input[name=rdoApplyTypoStyle]:checked').val();
                        if (val == 1) {
                            var links = document.getElementsByTagName("link");
                            for (var i = 0; i < links.length; i++) {
                                if (jQuery(links[i]).attr('data-name') == 'contentstyle') {

                                    var classname = jQuery(links[i]).attr('data-class');

                                    //check if classname used in content
                                    if (jQuery(".is-wrapper").find('.' + classname).length > 0) {
                                        jQuery(".is-wrapper").find('.' + classname).removeClass(classname);
                                        jQuery(links[i]).attr('data-rel', '_del');
                                    }

                                }
                            }
                            jQuery('[data-rel="_del"]').remove();
                        }

                        //Cleanup (remove previous css that has prefix 'basetype-')
                        var links = document.getElementsByTagName("link");
                        for (var i = 0; i < links.length; i++) {
                            var src = links[i].href.toLowerCase();
                            if (src.indexOf('basetype-') != -1) {
                                jQuery(links[i]).attr('data-rel', '_del');
                            }
                        }
                        jQuery('[data-rel="_del"]').remove();

                        //Add new page css
                        if (pageCss != '') {
                            jQuery('head').append('<link href="' + contentStylePath + pageCss + '" rel="stylesheet">');
                        }

                        $element.data("contentbox").hideModal($modal);

                        //Trigger Change event
                        $element.data("contentbox").settings.onChange();

                        return false;
                    });

                }

            }

            //Trigger Change event
            $element.data("contentbox").settings.onChange();
        };

        this.boxImage = function (s) {

            _fb.saveForUndo();

            jQuery("#lblWait").css("display", "none");

            /* Used if camera icon always shown
            if ($activeBox.find(".is-overlay").length == 0) {
            if ($activeBox.find(".is-boxes").length > 0) {
            var $isboxes = $activeBox.find(".is-boxes");
            var html = '<div class="is-overlay">' +
            '<div class="is-overlay-bg" style="background-image: url(' + s + ');"></div>' +
            '<div class="is-overlay-color"></div>' +
            '<div class="is-overlay-content"></div>' +
            '</div>';
            $isboxes.prepend(html);
            }
            }
            */

            if ($activeBox.find(".is-overlay").length == 0) {
                $activeBox.prepend('<div class="is-overlay"></div>');
            }
            var $overlay = $activeBox.find(".is-overlay");
            if ($overlay.find(".is-overlay-bg").length == 0) {
                //$overlay.prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
                $overlay.prepend('<div class="is-overlay-bg" style="transform:scale(1.05)" data-bottom-top="transform:translateY(-120px) scale(1.05);" data-top-bottom="transform:translateY(120px) scale(1.05)"></div>');
                $overlay.find(".is-overlay-bg").prepend('<div class="is-overlay-color" style="opacity:0.1"></div>');
            }
            $overlay.find(".is-overlay-bg").css("background-image", "url(" + s + ")");

            //$element.data("contentbox").boxBgColor("");
            $activeBox.css("background-color", "");
            /*if ($activeBox.find(".is-overlay-content .is-module").length == 0) {//If not is module
            $overlay.find(".is-overlay-bg").css("display", "block");
            }*/
            $activeBox.removeClass("is-bg-light");
            $activeBox.removeClass("is-bg-grey");
            $activeBox.removeClass("is-bg-dark");

            //Trigger Render event
            $element.data("contentbox").settings.onRender();

            //Trigger Change event
            $element.data("contentbox").settings.onChange();

        };

        this.destroy = function () {

            var html = this.html();

            $element.removeData('contentbox');
            $element.unbind();

            jQuery('#_cbhtml').remove();
            jQuery('body').removeClass('sidebar-active');

            jQuery('.is-wrapper').html(html);

            _fb.destroy();

        };

        this.init();

    };

    // source: https: //stackoverflow.com/questions/2255689/how-to-get-the-file-path-of-the-currently-executing-javascript-code
    function currentScriptPath() {
        var scripts = document.querySelectorAll('script[src]');
        var currentScript = scripts[scripts.length - 1].src;
        var currentScriptChunks = currentScript.split('/');
        var currentScriptFile = currentScriptChunks[currentScriptChunks.length - 1];
        return currentScript.replace(currentScriptFile, '');
    };

    function out(s) {
        if (bLangFile) {
            var result = _txt[s];
            if (result) return result;
            else return s;
        } else {
            return s;
        }
    };

    jQuery.fn.contentbox = function (options) {
        return this.each(function () {

            if (undefined == jQuery(this).data('contentbox')) {
                var plugin = new jQuery.contentbox(this, options);
                jQuery(this).data('contentbox', plugin);
            }
        });
    };
})(jQuery);

// source: http://stackoverflow.com/questions/1349404/generate-a-string-of-5-random-characters-in-javascript
function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for (var i = 0; i < 2; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    var text2 = "";
    var possible2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < 5; i++)
        text2 += possible2.charAt(Math.floor(Math.random() * possible2.length));

    return text + text2;
};

function applyBoxImage(s) {
    jQuery(".is-wrapper").data("contentbox").boxImage(s);
}
function applyTypography(className, contentCss, pageCss) {
    jQuery(".is-wrapper").data("contentbox").boxTypography(className, contentCss, pageCss);
}

function cleanupUnused() {

    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {

        //Remove unused google font links
        var src = jQuery(links[i]).attr('href');
        if (src.indexOf('googleapis') != -1) {
            //get fontname
            src = src.replace(/\+/g, ' ').replace(/%20/g, ' ');
            var fontname = src.substr(src.indexOf('family=') + 7);
            if (fontname.indexOf(':') != -1) {
                fontname = fontname.split(':')[0];
            }
            fontname = fontname.toLowerCase();
            //check if fontname used in content

            var exist = false;
            var tmp = jQuery(".is-wrapper").html().toLowerCase();
            var count = tmp.split(fontname).length;
            if (count >= 3) exist = true;

            if (!exist) {
                //jQuery(links[i]).attr('data-rel', '_del');
                var attr = jQuery(links[i]).attr('data-protect');
                if (typeof attr !== typeof undefined && attr !== false) {
                    //do not delete
                } else {
                    jQuery(links[i]).attr('data-rel', '_del');
                }
            }
        }

    }

    //Cleanup unused contentstyles
    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {
        if (jQuery(links[i]).attr('data-name') == 'contentstyle') {

            var classname = jQuery(links[i]).attr('data-class');

            //check if classname used in content
            if (classname == '') {//prevent problem if classname is empty (incorrect json data)
                jQuery(links[i]).attr('data-rel', '_del');
            }
            if (classname != '') {
                if (jQuery(".is-wrapper").find('.' + classname).length == 0) {
                    jQuery(links[i]).attr('data-rel', '_del');
                }
            }
        }
    }
    jQuery('[data-rel="_del"]').remove();

    /*Cleanup duplicate contentstyles.
    Possible duplicates can happen when adding new section with embedded contentstyles.
    If .sectionCss() is used (which in app/example will be added in <head>) then there will be duplicates (because it reads all contentstyles (type-*.css) and returned in .sectionCss().
    If .sectionCss() is NOT used, then there will be no duplicates.

    This cleanup is applicable when there is actual duplication found. All duplicates within .is-wrapper will be removed to make the .html() clean.
    If .sectionCss() is NOT used, all contentstyles embedded in .is-wrapper will stay.
    So there will be no problem whether .sectionCss() is used or not and no change needed on section templates(can still use embedded contentstyles)!

    How about basetype-*.css? basetype-*.css always included once (by cleanup previous basetype-*.css include). It only used if enableContentStyle is set true. And for this (enableContentStyle=true), .mainCss() method MUST BE USED.
    */
    jQuery("head").children('link').each(function () {

        var src = jQuery(this).attr('href');

        jQuery(".is-wrapper").children('link').each(function () {
            if (src == jQuery(this).attr('href')) {
                jQuery(this).attr('data-rel', '_del');
            }
        });

    });

    jQuery('[data-rel="_del"]').remove();

}


/*
source:
http://stackoverflow.com/questions/1043957/clearing-input-type-file-using-jquery
https://github.com/malsup/form/blob/master/jquery.form.js
*/
jQuery.fn.clearFields = jQuery.fn.clearInputs = function (includeHidden) {
    var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; // 'hidden' is not in this list
    return this.each(function () {
        var t = this.type, tag = this.tagName.toLowerCase();
        if (re.test(t) || tag == 'textarea') {
            this.value = '';
        }
        else if (t == 'checkbox' || t == 'radio') {
            this.checked = false;
        }
        else if (tag == 'select') {
            this.selectedIndex = -1;
        }
        else if (t == "file") {
            if (/MSIE/.test(navigator.userAgent)) {
                jQuery(this).replaceWith(jQuery(this).clone(true));
            } else {
                jQuery(this).val('');
            }
        }
        else if (includeHidden) {
            // includeHidden can be the value true, or it can be a selector string
            // indicating a special test; for example:
            //  jQuery('#myForm').clearForm('.special:hidden')
            // the above would clean hidden inputs that have the class of 'special'
            if ((includeHidden === true && /hidden/.test(t)) ||
                (typeof includeHidden == 'string' && jQuery(this).is(includeHidden)))
                this.value = '';
        }
    });
};

/*!
pace 1.0.0
Copyright (c) 2013 HubSpot, Inc.
MIT License
*/
(function () { var a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X = [].slice, Y = {}.hasOwnProperty, Z = function (a, b) { function c() { this.constructor = a } for (var d in b) Y.call(b, d) && (a[d] = b[d]); return c.prototype = b.prototype, a.prototype = new c, a.__super__ = b.prototype, a }, $ = [].indexOf || function (a) { for (var b = 0, c = this.length; c > b; b++) if (b in this && this[b] === a) return b; return -1 }; for (u = { catchupTime: 100, initialRate: .03, minTime: 250, ghostTime: 100, maxProgressPerFrame: 20, easeFactor: 1.25, startOnPageLoad: !0, restartOnPushState: !0, restartOnRequestAfter: 500, target: "body", elements: { checkInterval: 100, selectors: ["body"] }, eventLag: { minSamples: 10, sampleCount: 3, lagThreshold: 3 }, ajax: { trackMethods: ["GET"], trackWebSockets: !0, ignoreURLs: []} }, C = function () { var a; return null != (a = "undefined" != typeof performance && null !== performance && "function" == typeof performance.now ? performance.now() : void 0) ? a : +new Date }, E = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame, t = window.cancelAnimationFrame || window.mozCancelAnimationFrame, null == E && (E = function (a) { return setTimeout(a, 50) }, t = function (a) { return clearTimeout(a) }), G = function (a) { var b, c; return b = C(), (c = function () { var d; return d = C() - b, d >= 33 ? (b = C(), a(d, function () { return E(c) })) : setTimeout(c, 33 - d) })() }, F = function () { var a, b, c; return c = arguments[0], b = arguments[1], a = 3 <= arguments.length ? X.call(arguments, 2) : [], "function" == typeof c[b] ? c[b].apply(c, a) : c[b] }, v = function () { var a, b, c, d, e, f, g; for (b = arguments[0], d = 2 <= arguments.length ? X.call(arguments, 1) : [], f = 0, g = d.length; g > f; f++) if (c = d[f]) for (a in c) Y.call(c, a) && (e = c[a], null != b[a] && "object" == typeof b[a] && null != e && "object" == typeof e ? v(b[a], e) : b[a] = e); return b }, q = function (a) { var b, c, d, e, f; for (c = b = 0, e = 0, f = a.length; f > e; e++) d = a[e], c += Math.abs(d), b++; return c / b }, x = function (a, b) { var c, d, e; if (null == a && (a = "options"), null == b && (b = !0), e = document.querySelector("[data-pace-" + a + "]")) { if (c = e.getAttribute("data-pace-" + a), !b) return c; try { return JSON.parse(c) } catch (f) { return d = f, "undefined" != typeof console && null !== console ? console.error("Error parsing inline pace options", d) : void 0 } } }, g = function () { function a() { } return a.prototype.on = function (a, b, c, d) { var e; return null == d && (d = !1), null == this.bindings && (this.bindings = {}), null == (e = this.bindings)[a] && (e[a] = []), this.bindings[a].push({ handler: b, ctx: c, once: d }) }, a.prototype.once = function (a, b, c) { return this.on(a, b, c, !0) }, a.prototype.off = function (a, b) { var c, d, e; if (null != (null != (d = this.bindings) ? d[a] : void 0)) { if (null == b) return delete this.bindings[a]; for (c = 0, e = []; c < this.bindings[a].length; ) e.push(this.bindings[a][c].handler === b ? this.bindings[a].splice(c, 1) : c++); return e } }, a.prototype.trigger = function () { var a, b, c, d, e, f, g, h, i; if (c = arguments[0], a = 2 <= arguments.length ? X.call(arguments, 1) : [], null != (g = this.bindings) ? g[c] : void 0) { for (e = 0, i = []; e < this.bindings[c].length; ) h = this.bindings[c][e], d = h.handler, b = h.ctx, f = h.once, d.apply(null != b ? b : this, a), i.push(f ? this.bindings[c].splice(e, 1) : e++); return i } }, a } (), j = window.Pace || {}, window.Pace = j, v(j, g.prototype), D = j.options = v({}, u, window.paceOptions, x()), U = ["ajax", "document", "eventLag", "elements"], Q = 0, S = U.length; S > Q; Q++) K = U[Q], D[K] === !0 && (D[K] = u[K]); i = function (a) { function b() { return V = b.__super__.constructor.apply(this, arguments) } return Z(b, a), b } (Error), b = function () { function a() { this.progress = 0 } return a.prototype.getElement = function () { var a; if (null == this.el) { if (a = document.querySelector(D.target), !a) throw new i; this.el = document.createElement("div"), this.el.className = "pace pace-active", document.body.className = document.body.className.replace(/pace-done/g, ""), document.body.className += " pace-running", this.el.innerHTML = '<div class="pace-progress">\n  <div class="pace-progress-inner"></div>\n</div>\n<div class="pace-activity"></div>', null != a.firstChild ? a.insertBefore(this.el, a.firstChild) : a.appendChild(this.el) } return this.el }, a.prototype.finish = function () { var a; return a = this.getElement(), a.className = a.className.replace("pace-active", ""), a.className += " pace-inactive", document.body.className = document.body.className.replace("pace-running", ""), document.body.className += " pace-done" }, a.prototype.update = function (a) { return this.progress = a, this.render() }, a.prototype.destroy = function () { try { this.getElement().parentNode.removeChild(this.getElement()) } catch (a) { i = a } return this.el = void 0 }, a.prototype.render = function () { var a, b, c, d, e, f, g; if (null == document.querySelector(D.target)) return !1; for (a = this.getElement(), d = "translate3d(" + this.progress + "%, 0, 0)", g = ["webkitTransform", "msTransform", "transform"], e = 0, f = g.length; f > e; e++) b = g[e], a.children[0].style[b] = d; return (!this.lastRenderedProgress || this.lastRenderedProgress | 0 !== this.progress | 0) && (a.children[0].setAttribute("data-progress-text", "" + (0 | this.progress) + "%"), this.progress >= 100 ? c = "99" : (c = this.progress < 10 ? "0" : "", c += 0 | this.progress), a.children[0].setAttribute("data-progress", "" + c)), this.lastRenderedProgress = this.progress }, a.prototype.done = function () { return this.progress >= 100 }, a } (), h = function () { function a() { this.bindings = {} } return a.prototype.trigger = function (a, b) { var c, d, e, f, g; if (null != this.bindings[a]) { for (f = this.bindings[a], g = [], d = 0, e = f.length; e > d; d++) c = f[d], g.push(c.call(this, b)); return g } }, a.prototype.on = function (a, b) { var c; return null == (c = this.bindings)[a] && (c[a] = []), this.bindings[a].push(b) }, a } (), P = window.XMLHttpRequest, O = window.XDomainRequest, N = window.WebSocket, w = function (a, b) { var c, d, e, f; f = []; for (d in b.prototype) try { e = b.prototype[d], f.push(null == a[d] && "function" != typeof e ? a[d] = e : void 0) } catch (g) { c = g } return f }, A = [], j.ignore = function () { var a, b, c; return b = arguments[0], a = 2 <= arguments.length ? X.call(arguments, 1) : [], A.unshift("ignore"), c = b.apply(null, a), A.shift(), c }, j.track = function () { var a, b, c; return b = arguments[0], a = 2 <= arguments.length ? X.call(arguments, 1) : [], A.unshift("track"), c = b.apply(null, a), A.shift(), c }, J = function (a) { var b; if (null == a && (a = "GET"), "track" === A[0]) return "force"; if (!A.length && D.ajax) { if ("socket" === a && D.ajax.trackWebSockets) return !0; if (b = a.toUpperCase(), $.call(D.ajax.trackMethods, b) >= 0) return !0 } return !1 }, k = function (a) { function b() { var a, c = this; b.__super__.constructor.apply(this, arguments), a = function (a) { var b; return b = a.open, a.open = function (d, e) { return J(d) && c.trigger("request", { type: d, url: e, request: a }), b.apply(a, arguments) } }, window.XMLHttpRequest = function (b) { var c; return c = new P(b), a(c), c }; try { w(window.XMLHttpRequest, P) } catch (d) { } if (null != O) { window.XDomainRequest = function () { var b; return b = new O, a(b), b }; try { w(window.XDomainRequest, O) } catch (d) { } } if (null != N && D.ajax.trackWebSockets) { window.WebSocket = function (a, b) { var d; return d = null != b ? new N(a, b) : new N(a), J("socket") && c.trigger("request", { type: "socket", url: a, protocols: b, request: d }), d }; try { w(window.WebSocket, N) } catch (d) { } } } return Z(b, a), b } (h), R = null, y = function () { return null == R && (R = new k), R }, I = function (a) { var b, c, d, e; for (e = D.ajax.ignoreURLs, c = 0, d = e.length; d > c; c++) if (b = e[c], "string" == typeof b) { if (-1 !== a.indexOf(b)) return !0 } else if (b.test(a)) return !0; return !1 }, y().on("request", function (b) { var c, d, e, f, g; return f = b.type, e = b.request, g = b.url, I(g) ? void 0 : j.running || D.restartOnRequestAfter === !1 && "force" !== J(f) ? void 0 : (d = arguments, c = D.restartOnRequestAfter || 0, "boolean" == typeof c && (c = 0), setTimeout(function () { var b, c, g, h, i, k; if (b = "socket" === f ? e.readyState < 2 : 0 < (h = e.readyState) && 4 > h) { for (j.restart(), i = j.sources, k = [], c = 0, g = i.length; g > c; c++) { if (K = i[c], K instanceof a) { K.watch.apply(K, d); break } k.push(void 0) } return k } }, c)) }), a = function () { function a() { var a = this; this.elements = [], y().on("request", function () { return a.watch.apply(a, arguments) }) } return a.prototype.watch = function (a) { var b, c, d, e; return d = a.type, b = a.request, e = a.url, I(e) ? void 0 : (c = "socket" === d ? new n(b) : new o(b), this.elements.push(c)) }, a } (), o = function () { function a(a) { var b, c, d, e, f, g, h = this; if (this.progress = 0, null != window.ProgressEvent) for (c = null, a.addEventListener("progress", function (a) { return h.progress = a.lengthComputable ? 100 * a.loaded / a.total : h.progress + (100 - h.progress) / 2 }, !1), g = ["load", "abort", "timeout", "error"], d = 0, e = g.length; e > d; d++) b = g[d], a.addEventListener(b, function () { return h.progress = 100 }, !1); else f = a.onreadystatechange, a.onreadystatechange = function () { var b; return 0 === (b = a.readyState) || 4 === b ? h.progress = 100 : 3 === a.readyState && (h.progress = 50), "function" == typeof f ? f.apply(null, arguments) : void 0 } } return a } (), n = function () { function a(a) { var b, c, d, e, f = this; for (this.progress = 0, e = ["error", "open"], c = 0, d = e.length; d > c; c++) b = e[c], a.addEventListener(b, function () { return f.progress = 100 }, !1) } return a } (), d = function () { function a(a) { var b, c, d, f; for (null == a && (a = {}), this.elements = [], null == a.selectors && (a.selectors = []), f = a.selectors, c = 0, d = f.length; d > c; c++) b = f[c], this.elements.push(new e(b)) } return a } (), e = function () { function a(a) { this.selector = a, this.progress = 0, this.check() } return a.prototype.check = function () { var a = this; return document.querySelector(this.selector) ? this.done() : setTimeout(function () { return a.check() }, D.elements.checkInterval) }, a.prototype.done = function () { return this.progress = 100 }, a } (), c = function () { function a() { var a, b, c = this; this.progress = null != (b = this.states[document.readyState]) ? b : 100, a = document.onreadystatechange, document.onreadystatechange = function () { return null != c.states[document.readyState] && (c.progress = c.states[document.readyState]), "function" == typeof a ? a.apply(null, arguments) : void 0 } } return a.prototype.states = { loading: 0, interactive: 50, complete: 100 }, a } (), f = function () { function a() { var a, b, c, d, e, f = this; this.progress = 0, a = 0, e = [], d = 0, c = C(), b = setInterval(function () { var g; return g = C() - c - 50, c = C(), e.push(g), e.length > D.eventLag.sampleCount && e.shift(), a = q(e), ++d >= D.eventLag.minSamples && a < D.eventLag.lagThreshold ? (f.progress = 100, clearInterval(b)) : f.progress = 100 * (3 / (a + 3)) }, 50) } return a } (), m = function () { function a(a) { this.source = a, this.last = this.sinceLastUpdate = 0, this.rate = D.initialRate, this.catchup = 0, this.progress = this.lastProgress = 0, null != this.source && (this.progress = F(this.source, "progress")) } return a.prototype.tick = function (a, b) { var c; return null == b && (b = F(this.source, "progress")), b >= 100 && (this.done = !0), b === this.last ? this.sinceLastUpdate += a : (this.sinceLastUpdate && (this.rate = (b - this.last) / this.sinceLastUpdate), this.catchup = (b - this.progress) / D.catchupTime, this.sinceLastUpdate = 0, this.last = b), b > this.progress && (this.progress += this.catchup * a), c = 1 - Math.pow(this.progress / 100, D.easeFactor), this.progress += c * this.rate * a, this.progress = Math.min(this.lastProgress + D.maxProgressPerFrame, this.progress), this.progress = Math.max(0, this.progress), this.progress = Math.min(100, this.progress), this.lastProgress = this.progress, this.progress }, a } (), L = null, H = null, r = null, M = null, p = null, s = null, j.running = !1, z = function () { return D.restartOnPushState ? j.restart() : void 0 }, null != window.history.pushState && (T = window.history.pushState, window.history.pushState = function () { return z(), T.apply(window.history, arguments) }), null != window.history.replaceState && (W = window.history.replaceState, window.history.replaceState = function () { return z(), W.apply(window.history, arguments) }), l = { ajax: a, elements: d, document: c, eventLag: f }, (B = function () { var a, c, d, e, f, g, h, i; for (j.sources = L = [], g = ["ajax", "elements", "document", "eventLag"], c = 0, e = g.length; e > c; c++) a = g[c], D[a] !== !1 && L.push(new l[a](D[a])); for (i = null != (h = D.extraSources) ? h : [], d = 0, f = i.length; f > d; d++) K = i[d], L.push(new K(D)); return j.bar = r = new b, H = [], M = new m })(), j.stop = function () { return j.trigger("stop"), j.running = !1, r.destroy(), s = !0, null != p && ("function" == typeof t && t(p), p = null), B() }, j.restart = function () { return j.trigger("restart"), j.stop(), j.start() }, j.go = function () { var a; return j.running = !0, r.render(), a = C(), s = !1, p = G(function (b, c) { var d, e, f, g, h, i, k, l, n, o, p, q, t, u, v, w; for (l = 100 - r.progress, e = p = 0, f = !0, i = q = 0, u = L.length; u > q; i = ++q) for (K = L[i], o = null != H[i] ? H[i] : H[i] = [], h = null != (w = K.elements) ? w : [K], k = t = 0, v = h.length; v > t; k = ++t) g = h[k], n = null != o[k] ? o[k] : o[k] = new m(g), f &= n.done, n.done || (e++, p += n.tick(b)); return d = p / e, r.update(M.tick(b, d)), r.done() || f || s ? (r.update(100), j.trigger("done"), setTimeout(function () { return r.finish(), j.running = !1, j.trigger("hide") }, Math.max(D.ghostTime, Math.max(D.minTime - (C() - a), 0)))) : c() }) }, j.start = function (a) { v(D, a), j.running = !0; try { r.render() } catch (b) { i = b } return document.querySelector(".pace") ? (j.trigger("start"), j.go()) : setTimeout(j.start, 50) }, "function" == typeof define && define.amd ? define(function () { return j }) : "object" == typeof exports ? module.exports = j : D.startOnPageLoad && j.start() }).call(this);
Pace.on("hide", function () {
    $('.pace-inactive').remove();

    $(".is-wrapper").css('opacity',1);
    $(".is-wrapper").fadeIn();
});

