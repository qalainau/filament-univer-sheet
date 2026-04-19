<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div
        x-data="{
            instance: null,
            init() {
                this.$nextTick(() => this.waitAndMount());
            },
            waitAndMount() {
                if (!this.$el || this.$el.clientWidth === 0 || this.$el.clientHeight === 0 || !window.__univerSheet) {
                    requestAnimationFrame(() => this.waitAndMount());
                    return;
                }
                this.mount();
            },
            mount() {
                const container = document.createElement('div');
                container.style.cssText = 'width:100%;height:100%;';
                this.$el.appendChild(container);

                const data = @js($getState());
                const parsed = typeof data === 'string' ? JSON.parse(data) : data;

                this.instance = window.__univerSheet.create(container, {
                    data: parsed && typeof parsed === 'object' ? JSON.parse(JSON.stringify(parsed)) : undefined,
                    locale: @js($getLocale()),
                    readOnly: true,
                    toolbar: @js($getShowToolbar()),
                    formulaBar: @js($getShowFormulaBar()),
                    footer: @js($getShowSheetTabs()),
                });
            },
            destroy() {
                if (this.instance) { this.instance.destroy(); this.instance = null; }
            },
        }"
        style="width:100%; height:{{ $getHeight() ?? '100%' }}; min-height:300px; position:relative;"
        class="rounded-lg border border-gray-300 dark:border-gray-700"
    >
    </div>
</x-dynamic-component>
