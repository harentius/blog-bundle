import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import ButtonView from '@ckeditor/ckeditor5-ui/src/button/buttonview';
import readmore from './theme/readmore.svg';

export default class PageBreakUI extends Plugin {
  init() {
    const { editor } = this;
    const { t } = editor;

    editor.ui.componentFactory.add('readMore', locale => {
      const command = editor.commands.get('readMore');
      const view = new ButtonView(locale);

      view.set({
        label: t('Read more'),
        icon: readmore,
        tooltip: true,
      });

      view.bind('isEnabled').to(command, 'isEnabled');

      this.listenTo(view, 'execute', () => editor.execute('readMore'));

      return view;
    });
  }
}
