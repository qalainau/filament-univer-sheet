@php
    $state = $getState();
    $rows = $getPreviewRows();
    $columns = $getPreviewColumns();

    $previewData = [];
    $hasData = false;

    if (is_array($state) && isset($state['sheets'])) {
        $firstSheet = collect($state['sheets'])->first();
        if (isset($firstSheet['cellData']) && is_array($firstSheet['cellData'])) {
            foreach ($firstSheet['cellData'] as $r => $row) {
                if ((int) $r >= $rows) break;
                if (!is_array($row)) continue;
                foreach ($row as $c => $cell) {
                    if ((int) $c >= $columns) continue;
                    $value = is_array($cell) ? ($cell['v'] ?? '') : $cell;
                    if ($value !== '' && $value !== null) {
                        $hasData = true;
                    }
                    $previewData[(int) $r][(int) $c] = $value;
                }
            }
        }
    }

    $borderColor = '#e5e7eb';
    $borderColorDark = '#374151';
    $headerBg = '#f9fafb';
    $headerBgDark = '#1f2937';
@endphp

<div class="fi-ta-col-spreadsheet">
    @if ($hasData)
        @php $previewHeight = $getPreviewHeight(); @endphp
        <div style="{{ $previewHeight ? 'max-height:' . $previewHeight . ';' : '' }}overflow:hidden;border-radius:6px;border:1px solid {{ $borderColor }};background:#fff;font-family:ui-monospace,SFMono-Regular,monospace;font-size:11px;line-height:1;display:inline-block;">
            <table style="width:100%;border-collapse:collapse;">
                @for ($r = 0; $r < $rows; $r++)
                    @php $isLastRow = $r === $rows - 1; @endphp
                    <tr>
                        <td style="width:22px;padding:2px 4px;text-align:center;font-size:9px;color:#9ca3af;background:{{ $headerBg }};border-right:1px solid {{ $borderColor }};{{ $isLastRow ? '' : 'border-bottom:1px solid ' . $borderColor . ';' }}user-select:none;">
                            {{ $r + 1 }}
                        </td>
                        @for ($c = 0; $c < $columns; $c++)
                            @php
                                $val = $previewData[$r][$c] ?? '';
                                $isNumeric = is_numeric($val);
                                $isHeader = $r === 0;
                            @endphp
                            <td style="max-width:72px;padding:2px 6px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;border-right:1px solid {{ $borderColor }};{{ $isLastRow ? '' : 'border-bottom:1px solid ' . $borderColor . ';' }}text-align:{{ $isNumeric ? 'right' : 'left' }};{{ $isHeader ? 'font-weight:600;color:#374151;background:' . $headerBg . ';' : 'color:#6b7280;' }}">
                                {{ $val }}
                            </td>
                        @endfor
                    </tr>
                @endfor
            </table>
        </div>
    @else
        <span style="font-size:12px;color:#9ca3af;">&mdash;</span>
    @endif
</div>
