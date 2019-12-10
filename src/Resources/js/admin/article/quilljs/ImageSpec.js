import { DeleteAction, ResizeAction, AlignAction, ImageSpec as BaseImageSpec } from 'quill-blot-formatter';

class ImageSpec extends BaseImageSpec {
  getActions() {
    return [DeleteAction, ResizeAction, AlignAction];
  }

  init() {
    this.formatter.quill.root.addEventListener('click', this.onClick);

    this.formatter.quill.root.addEventListener('scroll', () => {
      this.formatter.repositionOverlay();
    });

    this.formatter.quill.on('editor-change', (eventName, ...args) => {
      if (eventName === 'selection-change' && args[2] === 'api') {
        setTimeout(() => {
          this.formatter.repositionOverlay();
        }, 10);
      }
    });
  }
}

export default ImageSpec;
