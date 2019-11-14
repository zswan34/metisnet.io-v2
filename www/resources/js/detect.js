const WhichBrowser = require('which-browser'); // https://github.com/WhichBrowser/Parser-JavaScript
const result = new WhichBrowser(navigator.userAgent);

let Detect = {
    browser: {
        getName: () => {
            return result.browser.name;
        },
        getVersion: () => {
            return result.browser.version.toString();
        },
        getVersionValue: () => {
            return result.browser.version.value;
        },
        getEngine: () => {
            return result.engine.name;
        }
    },
    os: {
        getName: () => {
            return result.os.name;
        },
        getVersion: () => {
            return result.os.version.toString();
        },
        getVersionValue: () => {
            return result.os.version.value;
        }
    },
    device: {
        getType: () => {
            return result.device.type;
        },
        getSubType: () => {
            return result.device.subtype
        },
        isIdentified: () => {
            return result.device.identified;
        },
        getManufacturer: () => {
            return result.device.manufacturer;
        }
    },
    window: {
        getDimensions: () => {
            return JSON.stringify({width: window.innerWidth, height: window.innerHeight});
        }
    }
};
