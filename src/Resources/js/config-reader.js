class ConfigReader {
  constructor() {
    this.config = {};
    this.initialized = false;
  }

  initialize() {
    const el = window.document.getElementById('js-config');

    if (!el) {
      return;
    }

    this.config = JSON.parse(el.textContent);
    this.initialized = true;
  }

  get(key, def) {
    if (!this.initialized) {
      this.initialize();
    }

    if (typeof this.config[key] === 'undefined' || this.config[key] === null) {
      return def;
    }

    return this.config[key];
  }
}

const configReader = new ConfigReader();

export default configReader;
