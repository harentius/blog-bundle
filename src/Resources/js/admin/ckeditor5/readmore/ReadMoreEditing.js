import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import { toWidget } from '@ckeditor/ckeditor5-widget/src/utils';
import ReadMoreCommand from './ReadMoreCommand';
import './theme/style.scss';

function toPageBreakWidget(viewElement, writer, label) {
  writer.setCustomProperty('readMore', true, viewElement);

  return toWidget(viewElement, writer, { label });
}

export default class ReadMoreEditing extends Plugin {
  static get pluginName() {
    return 'ReadMoreEditing';
  }

  init() {
    const { editor } = this;
    const { schema } = editor.model;
    const { t } = editor;
    const { conversion } = editor;

    schema.register('readMore', {
      isObject: true,
      allowWhere: '$block',
    });

    conversion.for('dataDowncast').elementToElement({
      model: 'readMore',
      view: (modelElement, viewWriter) => viewWriter.createContainerElement('p', { class: 'read-more' }),
    });

    conversion.for('editingDowncast').elementToElement({
      model: 'readMore',
      view: (modelElement, viewWriter) => {
        const label = t('Read More');
        const viewWrapper = viewWriter.createContainerElement('p');
        const viewLabelElement = viewWriter.createContainerElement('span');
        const innerText = viewWriter.createText(t('Read More'));

        viewWriter.addClass('read-more', viewWrapper);
        viewWriter.setCustomProperty('readMore', true, viewWrapper);

        viewWriter.addClass('read-more__label', viewLabelElement);

        viewWriter.insert(viewWriter.createPositionAt(viewWrapper, 0), viewLabelElement);
        viewWriter.insert(viewWriter.createPositionAt(viewLabelElement, 0), innerText);

        return toPageBreakWidget(viewWrapper, viewWriter, label);
      },
    });

    conversion.for('upcast')
      .elementToElement({
        view: element => {
          if (!element.is('p') || !element.hasClass('read-more')) {
            return null;
          }

          return { name: true };
        },
        model: 'readMore',
      });

    editor.commands.add('readMore', new ReadMoreCommand(editor));
  }
}
