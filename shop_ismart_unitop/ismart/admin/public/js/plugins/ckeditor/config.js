/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.allowedContent = true;
    // đường dẫn thế này vì MVC đang có cấu trúc domain.com/?linkxuly
    config.filebrowserBrowseUrl = 'public/js/plugins/ckfinder/ckfinder.html';
    config.filebrowserUploadUrl = 'public/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

};


