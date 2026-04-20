import React from 'react';
import { createUniver, defaultTheme } from '@univerjs/presets';
import { UniverSheetsCorePreset } from '@univerjs/preset-sheets-core';
import { LocaleType, merge } from '@univerjs/core';
import enUS from '@univerjs/preset-sheets-core/locales/en-US';
import jaJP from '@univerjs/preset-sheets-core/locales/ja-JP';
import zhCN from '@univerjs/preset-sheets-core/locales/zh-CN';
import zhTW from '@univerjs/preset-sheets-core/locales/zh-TW';
import koKR from '@univerjs/preset-sheets-core/locales/ko-KR';
import frFR from '@univerjs/preset-sheets-core/locales/fr-FR';
import ruRU from '@univerjs/preset-sheets-core/locales/ru-RU';
import esES from '@univerjs/preset-sheets-core/locales/es-ES';
import caES from '@univerjs/preset-sheets-core/locales/ca-ES';
import viVN from '@univerjs/preset-sheets-core/locales/vi-VN';
import faIR from '@univerjs/preset-sheets-core/locales/fa-IR';
import skSK from '@univerjs/preset-sheets-core/locales/sk-SK';
import '@univerjs/preset-sheets-core/lib/index.css';

const LOCALE_MAP = {
    'en-US': { type: LocaleType.EN_US, data: enUS },
    'ja-JP': { type: LocaleType.JA_JP, data: jaJP },
    'zh-CN': { type: LocaleType.ZH_CN, data: zhCN },
    'zh-TW': { type: LocaleType.ZH_TW, data: zhTW },
    'ko-KR': { type: LocaleType.KO_KR, data: koKR },
    'fr-FR': { type: LocaleType.FR_FR, data: frFR },
    'ru-RU': { type: LocaleType.RU_RU, data: ruRU },
    'es-ES': { type: LocaleType.ES_ES, data: esES },
    'ca-ES': { type: LocaleType.CA_ES, data: caES },
    'vi-VN': { type: LocaleType.VI_VN, data: viVN },
    'fa-IR': { type: LocaleType.FA_IR, data: faIR },
    'sk-SK': { type: LocaleType.SK_SK, data: skSK },
};

class ErrorBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = { hasError: false };
    }

    static getDerivedStateFromError() {
        return { hasError: true };
    }

    componentDidCatch() {
        if (this.props.onError) {
            this.props.onError();
        }
    }

    render() {
        if (this.state.hasError) {
            return null;
        }
        return this.props.children;
    }
}

window.__univerSheet = {
    create(container, options = {}) {
        let retries = 0;
        let univerAPI = null;
        let resizeObserver = null;
        let debounceTimer = null;

        function doCreate() {
            try {
                const presetOptions = { container };
                if (options.toolbar === false) {
                    presetOptions.toolbar = false;
                }
                if (options.formulaBar === false) {
                    presetOptions.formulaBar = false;
                }
                if (options.header === false) {
                    presetOptions.header = false;
                }
                if (options.footer === false) {
                    presetOptions.footer = false;
                }
                if (options.contextMenu === false) {
                    presetOptions.contextMenu = false;
                }
                if (options.ribbonType) {
                    presetOptions.ribbonType = options.ribbonType;
                }

                const localeKey = options.locale || 'en-US';
                const localeEntry = LOCALE_MAP[localeKey] || LOCALE_MAP['en-US'];

                const locales = {};
                locales[localeEntry.type] = merge({}, localeEntry.data);

                const result = createUniver({
                    locale: localeEntry.type,
                    locales,
                    theme: defaultTheme,
                    presets: [
                        UniverSheetsCorePreset(presetOptions),
                    ],
                });

                univerAPI = result.univerAPI;

                if (options.data && typeof options.data === 'object') {
                    univerAPI.createUniverSheet(options.data);
                } else {
                    univerAPI.createUniverSheet({ name: 'Sheet1' });
                }

                if (options.readOnly) {
                    const workbook = univerAPI.getActiveWorkbook();
                    if (workbook) {
                        workbook.setEditable(false);
                        workbook.disableSelection();
                    }
                    const perm = univerAPI.getPermission();
                    if (perm) {
                        perm.setWorkbookEditPermission(false);
                    }
                }

                if (options.onChange) {
                    univerAPI.onCommandExecuted(() => {
                        if (debounceTimer) {
                            clearTimeout(debounceTimer);
                        }
                        debounceTimer = setTimeout(() => {
                            if (!univerAPI) return;
                            const workbook = univerAPI.getActiveWorkbook();
                            if (!workbook) return;
                            const snapshot = workbook.getSnapshot();
                            options.onChange(JSON.parse(JSON.stringify(snapshot)));
                        }, 500);
                    });
                }

                resizeObserver = new ResizeObserver(() => {
                    try {
                        window.dispatchEvent(new Event('resize'));
                    } catch {}
                });
                resizeObserver.observe(container);
            } catch (e) {
                if (retries++ < 5) {
                    setTimeout(doCreate, 200 * retries);
                }
            }
        }

        doCreate();

        return {
            getAPI() {
                return univerAPI;
            },
            destroy() {
                if (debounceTimer) {
                    clearTimeout(debounceTimer);
                }
                if (resizeObserver) {
                    resizeObserver.disconnect();
                    resizeObserver = null;
                }
                if (univerAPI) {
                    try {
                        univerAPI.dispose();
                    } catch {}
                    univerAPI = null;
                }
            },
        };
    },
};
