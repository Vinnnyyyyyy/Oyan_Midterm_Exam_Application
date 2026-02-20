<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0a;
            --surface: #111111;
            --border: #222222;
            --accent: #c8f135;
            --accent2: #ff4d4d;
            --text: #e8e8e8;
            --muted: #555;
            --font-display: 'Bebas Neue', sans-serif;
            --font-body: 'DM Mono', monospace;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
            min-height: 100vh;
            padding: 60px 40px;
            overflow-x: hidden;
        }

        /* Noise texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }

        .wrapper {
            max-width: 960px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
            margin-bottom: 48px;
            animation: slideDown 0.6s ease both;
        }

        .header-left .eyebrow {
            font-size: 10px;
            letter-spacing: 0.25em;
            color: var(--accent);
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .header-left h1 {
            font-family: var(--font-display);
            font-size: clamp(52px, 8vw, 96px);
            line-height: 0.9;
            color: var(--text);
            letter-spacing: 0.02em;
        }

        .header-right {
            text-align: right;
            font-size: 11px;
            color: var(--muted);
            line-height: 1.7;
        }

        .header-right span {
            display: block;
        }

        .header-right .count {
            font-size: 28px;
            font-family: var(--font-display);
            color: var(--accent);
            line-height: 1;
        }

        /* ── Table ── */
        .table-wrap {
            animation: fadeUp 0.7s ease 0.2s both;
        }

        .col-labels {
            display: grid;
            grid-template-columns: 40px 1fr 160px 120px;
            gap: 0 24px;
            padding: 0 16px 10px;
            font-size: 10px;
            letter-spacing: 0.18em;
            color: var(--muted);
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
            margin-bottom: 6px;
        }

        .product-row {
            display: grid;
            grid-template-columns: 40px 1fr 160px 120px;
            gap: 0 24px;
            align-items: center;
            padding: 18px 16px;
            border-bottom: 1px solid #191919;
            position: relative;
            cursor: default;
            transition: background 0.2s ease;
            animation: fadeUp 0.5s ease both;
        }

        .product-row:nth-child(1) { animation-delay: 0.30s; }
        .product-row:nth-child(2) { animation-delay: 0.38s; }
        .product-row:nth-child(3) { animation-delay: 0.46s; }
        .product-row:nth-child(4) { animation-delay: 0.54s; }
        .product-row:nth-child(5) { animation-delay: 0.62s; }

        .product-row::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--accent);
            transform: scaleY(0);
            transition: transform 0.2s ease;
            transform-origin: bottom;
        }

        .product-row:hover {
            background: #141414;
        }

        .product-row:hover::before {
            transform: scaleY(1);
        }

        .col-id {
            font-size: 11px;
            color: var(--muted);
            font-weight: 300;
        }

        .col-name {
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        .col-price {
            font-size: 14px;
            font-weight: 500;
            color: var(--accent);
            letter-spacing: 0.04em;
        }

        .col-stock {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
        }

        .stock-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .stock-ok .stock-dot  { background: var(--accent); box-shadow: 0 0 6px var(--accent); }
        .stock-low .stock-dot { background: var(--accent2); box-shadow: 0 0 6px var(--accent2); }
        .stock-ok  { color: #aaa; }
        .stock-low { color: var(--accent2); }

        /* ── Footer bar ── */
        .footer-bar {
            margin-top: 48px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            letter-spacing: 0.16em;
            color: var(--muted);
            text-transform: uppercase;
            animation: fadeUp 0.6s ease 0.8s both;
        }

        .footer-bar .tag {
            background: var(--accent);
            color: #000;
            padding: 3px 8px;
            font-size: 9px;
            letter-spacing: 0.2em;
            font-weight: 500;
        }

        /* ── Animations ── */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            body { padding: 40px 20px; }
            .col-labels,
            .product-row {
                grid-template-columns: 30px 1fr 120px;
            }
            .col-labels .lbl-stock,
            .product-row .col-stock { display: none; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <header class="header">
        <div class="header-left">
            <p class="eyebrow">// Product Catalog</p>
            <h1>INVENTORY</h1>
        </div>
        <div class="header-right">
            <span class="count">{{ count($products) }}</span>
            <span>items listed</span>
            <span>{{ date('Y-m-d') }}</span>
        </div>
    </header>

    {{-- Table --}}
    <div class="table-wrap">
        <div class="col-labels">
            <span>#</span>
            <span>Product Name</span>
            <span>Price</span>
            <span class="lbl-stock">Stock</span>
        </div>

        @forelse ($products as $product)
            <div class="product-row">
                <span class="col-id">{{ str_pad($product['id'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="col-name">{{ $product['name'] }}</span>
                <span class="col-price">₱{{ number_format($product['price'], 2) }}</span>
                <span class="col-stock {{ $product['stock'] <= 10 ? 'stock-low' : 'stock-ok' }}">
                    <span class="stock-dot"></span>
                    {{ $product['stock'] }} {{ $product['stock'] <= 10 ? 'Low' : 'In Stock' }}
                </span>
            </div>
        @empty
            <div class="product-row">
                <span class="col-id">—</span>
                <span class="col-name" style="color:var(--muted)">No products found.</span>
                <span></span><span></span>
            </div>
        @endforelse
    </div>

    {{-- Footer --}}
    <div class="footer-bar">
        <span>Laravel Product App</span>
        <span class="tag">Active</span>
    </div>

</div>
</body>
</html>