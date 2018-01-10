class ConfigReader {
  constructor() {
    this.config = {};
    const el = document.getElementById('js-config');

    if (!el) {
      return;
    }

    this.config = JSON.parse(el.textContent);
  }

  get(key, def) {
    if (typeof(this.config[key]) === 'undefined' || this.config[key] === null) {
      return def;
    }

    return this.config[key];
  }
}

const configReader = new ConfigReader();

export { configReader };
