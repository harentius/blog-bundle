// This Plugin inspired by https://github.com/ckeditor/ckeditor5-page-break.git
import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import ReadMoreEditing from './ReadMoreEditing';
import ReadMoreUi from './ReadMoreUi';

export default class PageBreak extends Plugin {
  static get requires() {
    return [ReadMoreEditing, ReadMoreUi];
  }

  static get pluginName() {
    return 'ReadMore';
  }
}
