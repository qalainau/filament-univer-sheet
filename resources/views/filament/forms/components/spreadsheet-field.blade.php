<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $statePath = $getStatePath();
        $key = $getLivewireKey() . '.' . $statePath;
        $height = $getHeight() ?? '60vh';
        $minHeight = $getMinHeight();
        $style = "width:100%;position:relative;height:{$height};min-height:{$minHeight};";
    @endphp
    <div
        x-data="{
            instance: null,
            _debounce: null,
            init() {
                this.$nextTick(() => this.waitAndMount());
            },
            waitAndMount() {
                if (!this.$el || this.$el.clientWidth === 0 || this.$el.clientHeight === 0 || !window.__univerSheet) {
                    requestAnimationFrame(() => this.waitAndMount());
                    return;
                }
                this.tryMount(0);
            },
            tryMount(attempt) {
                const container = document.createElement('div');
                container.style.cssText = 'width:100%;height:100%;';
                this.$el.appendChild(container);

                const initialData = $wire.get('{{ $statePath }}');
                const data = initialData ? JSON.parse(JSON.stringify(initialData)) : undefined;

                try {
                    this.instance = window.__univerSheet.create(container, {
                        data: data && typeof data === 'object' ? data : undefined,
                        locale: @js($getLocale()),
                        onChange: (snapshot) => {
                            if (this._debounce) clearTimeout(this._debounce);
                            this._debounce = setTimeout(() => {
                                $wire.set('{{ $statePath }}', JSON.parse(JSON.stringify(snapshot)));
                            }, 500);
                        },
                    });
                } catch (e) {
                    container.remove();
                    if (attempt < 5) {
                        setTimeout(() => this.tryMount(attempt + 1), 300 * (attempt + 1));
                    }
                }
            },
            destroy() {
                if (this._debounce) clearTimeout(this._debounce);
                if (this.instance) { this.instance.destroy(); this.instance = null; }
            },
        }"
        wire:ignore
        wire:key="{{ $key }}"
        style="{{ $style }}"
        class="rounded-lg border border-gray-300 dark:border-gray-700"
    >
    </div>
</x-dynamic-component>
