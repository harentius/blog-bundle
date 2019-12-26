import Command from '@ckeditor/ckeditor5-core/src/command';
import { findOptimalInsertionPosition } from '@ckeditor/ckeditor5-widget/src/utils';

function getInsertReadMoreParent(selection, model) {
  const insertAt = findOptimalInsertionPosition(selection, model);

  const { parent } = insertAt;

  if (parent.isEmpty && !parent.is('$root')) {
    return parent.parent;
  }

  return parent;
}

function isReadMoreAllowedInParent(selection, schema, model) {
  const parent = getInsertReadMoreParent(selection, model);

  return schema.checkChild(parent, 'readMore');
}

function checkSelectionOnObject(selection, schema) {
  const selectedElement = selection.getSelectedElement();

  return selectedElement && schema.isObject(selectedElement);
}

function isReadMoreAllowed(model) {
  const { schema } = model;
  const { selection } = model.document;

  return isReadMoreAllowedInParent(selection, schema, model) &&
    !checkSelectionOnObject(selection, schema);
}

class ReadMoreCommand extends Command {
  refresh() {
    this.isEnabled = isReadMoreAllowed(this.editor.model);
  }

  execute() {
    const { model } = this.editor;

    model.change(writer => {
      const pageBreakElement = writer.createElement('readMore');
      model.insertContent(pageBreakElement);
      let nextElement = pageBreakElement.nextSibling;

      const canSetSelection = nextElement && model.schema.checkChild(nextElement, '$text');

      if (!canSetSelection && model.schema.checkChild(pageBreakElement.parent, 'paragraph')) {
        nextElement = writer.createElement('paragraph');

        model.insertContent(nextElement, writer.createPositionAfter(pageBreakElement));
      }

      if (nextElement) {
        writer.setSelection(nextElement, 0);
      }
    });
  }
}

export default ReadMoreCommand;
