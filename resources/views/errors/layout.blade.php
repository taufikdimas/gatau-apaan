<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Error') · Nemo Security Lab</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --bg-base: #06080e;
        --bg-surface: rgba(13, 18, 30, 0.75);
        --bg-card: rgba(18, 26, 44, 0.65);
        --border-glow: rgba(56, 189, 248, 0.25);
        --border-subtle: rgba(255, 255, 255, 0.08);
        --text-main: #f1f5f9;
        --text-muted: #94a3b8;
        --text-dim: #64748b;
        --accent-cyan: #06b6d4;
        --accent-blue: #3b82f6;
        --accent-purple: #8b5cf6;
        --accent-red: #ef4444;
        --accent-amber: #f59e0b;
        --accent-emerald: #10b981;
        --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        --font-mono: 'JetBrains Mono', monospace;
        --theme-color: @yield('accent_color', '#06b6d4');
        --theme-color-rgb: @yield('accent_color_rgb', '6, 182, 212');
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background-color: var(--bg-base);
        color: var(--text-main);
        font-family: var(--font-sans);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
        position: relative;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }

    /* Ambient scanlines & vignette */
    .scanlines {
        position: fixed;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.35) 50%),
            linear-gradient(90deg, rgba(255, 0, 0, 0.02), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.02));
        background-size: 100% 3px, 6px 100%;
        z-index: 10;
        opacity: 0.7;
    }

    .ambient-glow {
        position: fixed;
        inset: 0;
        pointer-events: none;
        background: radial-gradient(circle at 50% 30%, rgba(var(--theme-color-rgb), 0.12) 0%, transparent 70%);
        z-index: 1;
        transition: background 0.8s ease;
    }

    #cyberCanvas {
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 2;
    }

    /* Top Brand Navigation */
    .cyber-header {
        position: relative;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid var(--border-subtle);
        background: rgba(6, 8, 14, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .brand-box {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        color: var(--text-main);
    }

    .brand-logo-hex {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, rgba(var(--theme-color-rgb), 0.2), rgba(var(--theme-color-rgb), 0.05));
        border: 1px solid var(--theme-color);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--theme-color);
        box-shadow: 0 0 15px rgba(var(--theme-color-rgb), 0.3);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .brand-box:hover .brand-logo-hex {
        transform: scale(1.08) rotate(4deg);
    }

    .brand-title {
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: -0.01em;
        display: flex;
        flex-direction: column;
    }

    .brand-subtitle {
        font-family: var(--font-mono);
        font-size: 0.7rem;
        color: var(--text-muted);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .header-tools {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .tool-btn {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-subtle);
        color: var(--text-muted);
        padding: 0.45rem 0.85rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-family: var(--font-mono);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .tool-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--theme-color);
        color: var(--text-main);
        transform: translateY(-1px);
    }

    .tool-btn.active {
        background: rgba(var(--theme-color-rgb), 0.15);
        border-color: var(--theme-color);
        color: var(--theme-color);
    }

    /* Main Container */
    .main-stage {
        position: relative;
        z-index: 15;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1.5rem 4rem;
        max-width: 1040px;
        margin: 0 auto;
        width: 100%;
    }

    /* Error Cyber Card */
    .cyber-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-subtle);
        border-radius: 20px;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 3rem 2.5rem;
        width: 100%;
        position: relative;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5),
            0 0 40px rgba(var(--theme-color-rgb), 0.08);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr;
        gap: 2.5rem;
        text-align: center;
    }

    @media (min-width: 900px) {
        .cyber-card {
            grid-template-columns: 360px 1fr;
            text-align: left;
            align-items: center;
            padding: 3.5rem;
        }
    }

    .cyber-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--theme-color), transparent);
    }

    /* Tech corner brackets */
    .corner-tl,
    .corner-tr,
    .corner-bl,
    .corner-br {
        position: absolute;
        width: 12px;
        height: 12px;
        border-color: var(--theme-color);
        opacity: 0.6;
        pointer-events: none;
    }

    .corner-tl {
        top: 8px;
        left: 8px;
        border-top: 2px solid;
        border-left: 2px solid;
    }

    .corner-tr {
        top: 8px;
        right: 8px;
        border-top: 2px solid;
        border-right: 2px solid;
    }

    .corner-bl {
        bottom: 8px;
        left: 8px;
        border-bottom: 2px solid;
        border-left: 2px solid;
    }

    .corner-br {
        bottom: 8px;
        right: 8px;
        border-bottom: 2px solid;
        border-right: 2px solid;
    }

    /* Left Column: Visual Icon & Glitch Code */
    .visual-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .art-stage {
        position: relative;
        width: 220px;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .art-ring-outer {
        position: absolute;
        inset: 0;
        border: 2px dashed rgba(var(--theme-color-rgb), 0.3);
        border-radius: 50%;
        animation: spinClockwise 25s linear infinite;
    }

    .art-ring-inner {
        position: absolute;
        inset: 22px;
        border: 1px solid rgba(var(--theme-color-rgb), 0.2);
        border-top: 2px solid var(--theme-color);
        border-radius: 50%;
        animation: spinCounter 12s linear infinite;
    }

    .art-radar-sweep {
        position: absolute;
        inset: 30px;
        border-radius: 50%;
        background: conic-gradient(from 0deg at 50% 50%, rgba(var(--theme-color-rgb), 0.25) 0deg, transparent 60deg, transparent 360deg);
        animation: spinClockwise 4s linear infinite;
    }

    .art-center-glyph {
        position: relative;
        z-index: 5;
        width: 90px;
        height: 90px;
        border-radius: 18px;
        background: rgba(10, 15, 26, 0.9);
        border: 1px solid var(--theme-color);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 25px rgba(var(--theme-color-rgb), 0.35);
    }

    .art-center-glyph svg {
        width: 48px;
        height: 48px;
        stroke: var(--theme-color);
        filter: drop-shadow(0 0 8px rgba(var(--theme-color-rgb), 0.6));
    }

    /* 3D Cyber Glitch Number */
    .glitch-code-wrapper {
        position: relative;
        user-select: none;
        margin-top: 0.5rem;
    }

    .glitch-code {
        font-family: var(--font-mono);
        font-size: 5rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.04em;
        color: #fff;
        position: relative;
        display: inline-block;
        text-shadow: 0 0 20px rgba(var(--theme-color-rgb), 0.5);
    }

    .glitch-code::before,
    .glitch-code::after {
        content: attr(data-text);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        clip: rect(0, 0, 0, 0);
    }

    .glitch-code::before {
        left: -2px;
        text-shadow: 2px 0 var(--accent-red);
        animation: glitch-anim-1 2.5s infinite linear alternate-reverse;
    }

    .glitch-code::after {
        left: 2px;
        text-shadow: -2px 0 var(--theme-color);
        animation: glitch-anim-2 3s infinite linear alternate-reverse;
    }

    /* Right Column: Error Content & Details */
    .content-column {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .status-badge-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    @media (min-width: 900px) {
        .status-badge-row {
            justify-content: flex-start;
        }
    }

    .cyber-badge {
        font-family: var(--font-mono);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        background: rgba(var(--theme-color-rgb), 0.12);
        color: var(--theme-color);
        border: 1px solid rgba(var(--theme-color-rgb), 0.35);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--theme-color);
        box-shadow: 0 0 8px var(--theme-color);
        animation: pulseGlow 1.5s ease-in-out infinite;
    }

    .incident-badge {
        font-family: var(--font-mono);
        font-size: 0.75rem;
        color: var(--text-dim);
    }

    .error-heading {
        font-size: clamp(1.6rem, 3.5vw, 2.25rem);
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #ffffff;
        line-height: 1.2;
    }

    .error-subheading {
        font-size: 1.05rem;
        color: var(--text-muted);
        line-height: 1.6;
        max-width: 580px;
    }

    .humor-quote {
        background: rgba(255, 255, 255, 0.03);
        border-left: 3px solid var(--theme-color);
        padding: 0.85rem 1.15rem;
        border-radius: 0 8px 8px 0;
        font-size: 0.9rem;
        color: #cbd5e1;
        font-style: italic;
        position: relative;
        margin: 0.25rem 0;
    }

    /* Action Buttons */
    .btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.85rem;
        align-items: center;
        justify-content: center;
        margin-top: 0.5rem;
    }

    @media (min-width: 900px) {
        .btn-group {
            justify-content: flex-start;
        }
    }

    .btn-cyber-primary {
        background: linear-gradient(135deg, var(--theme-color), rgba(var(--theme-color-rgb), 0.8));
        color: #030712;
        font-weight: 700;
        font-size: 0.92rem;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 20px rgba(var(--theme-color-rgb), 0.35);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: none;
    }

    .btn-cyber-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(var(--theme-color-rgb), 0.55);
        filter: brightness(1.1);
    }

    .btn-cyber-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-main);
        font-weight: 600;
        font-size: 0.92rem;
        padding: 0.75rem 1.4rem;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid var(--border-subtle);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-cyber-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-cyber-fun {
        background: rgba(139, 92, 246, 0.15);
        color: #c4b5fd;
        font-weight: 600;
        font-size: 0.92rem;
        padding: 0.75rem 1.4rem;
        border-radius: 10px;
        border: 1px solid rgba(139, 92, 246, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cyber-fun:hover {
        background: rgba(139, 92, 246, 0.25);
        border-color: #a78bfa;
        color: #fff;
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.35);
        transform: translateY(-1px);
    }

    /* Diagnostics Bar */
    .diag-bar {
        margin-top: 1.5rem;
        width: 100%;
        background: rgba(10, 15, 26, 0.6);
        border: 1px solid var(--border-subtle);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        font-family: var(--font-mono);
        font-size: 0.8rem;
        color: var(--text-dim);
    }

    .diag-items {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        flex-wrap: wrap;
    }

    .diag-item span {
        color: var(--text-muted);
        font-weight: 500;
    }

    .copy-diag-btn {
        background: transparent;
        border: none;
        color: var(--theme-color);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-family: var(--font-mono);
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .copy-diag-btn:hover {
        background: rgba(var(--theme-color-rgb), 0.15);
    }

    /* Error Switcher / Test Bar */
    .error-switcher {
        position: relative;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        padding: 1rem 1.5rem 1.75rem;
        background: rgba(6, 8, 14, 0.7);
        border-top: 1px solid var(--border-subtle);
    }

    .switcher-label {
        font-family: var(--font-mono);
        font-size: 0.75rem;
        color: var(--text-dim);
        margin-right: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .switch-chip {
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
        font-family: var(--font-mono);
        font-size: 0.75rem;
        text-decoration: none;
        color: var(--text-muted);
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-subtle);
        transition: all 0.2s ease;
    }

    .switch-chip:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .switch-chip.active {
        background: rgba(var(--theme-color-rgb), 0.2);
        color: var(--theme-color);
        border-color: var(--theme-color);
        font-weight: 700;
    }

    /* Drawer / Modals: Mini Game & Interactive Terminal */
    .cyber-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 100;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .cyber-modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .cyber-modal {
        background: #0a0f1d;
        border: 1px solid var(--theme-color);
        box-shadow: 0 0 50px rgba(var(--theme-color-rgb), 0.35);
        border-radius: 16px;
        width: 100%;
        max-width: 680px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .cyber-modal-overlay.active .cyber-modal {
        transform: scale(1);
    }

    .modal-header {
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid var(--border-subtle);
        padding: 0.85rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-family: var(--font-mono);
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--theme-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-close-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.2rem 0.5rem;
        line-height: 1;
        transition: color 0.2s;
    }

    .modal-close-btn:hover {
        color: #ef4444;
    }



    /* Game Specifics */
    .game-body {
        position: relative;
        background: radial-gradient(circle at 50% 50%, #0c1427 0%, #040711 100%);
        height: 480px;
        overflow: hidden;
        user-select: none;
    }

    #gameCanvas {
        width: 100%;
        height: 100%;
        display: block;
        cursor: none;
        touch-action: none;
    }

    .game-hud {
        position: absolute;
        top: 14px;
        left: 16px;
        right: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        font-family: var(--font-mono);
        font-size: 0.85rem;
        color: #fff;
        pointer-events: none;
        z-index: 10;
    }

    .game-hud-stat {
        background: rgba(10, 16, 30, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 5px 12px;
        border-radius: 8px;
        backdrop-filter: blur(6px);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .game-hud-stat span {
        color: var(--accent-cyan);
        font-weight: 700;
    }

    .game-overlay-msg {
        position: absolute;
        inset: 0;
        background: rgba(5, 8, 18, 0.85);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        z-index: 20;
        padding: 1.5rem;
        text-align: center;
    }

    .toast-msg {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0f172a;
        border: 1px solid var(--theme-color);
        color: #fff;
        font-family: var(--font-mono);
        font-size: 0.82rem;
        padding: 0.65rem 1.25rem;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        z-index: 999;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .toast-msg.show {
        transform: translateY(0);
        opacity: 1;
    }

    /* Keyframe Animations */
    @keyframes spinClockwise {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes spinCounter {
        from {
            transform: rotate(360deg);
        }

        to {
            transform: rotate(0deg);
        }
    }

    @keyframes pulseGlow {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.4;
            transform: scale(0.85);
        }
    }

    @keyframes glitch-anim-1 {
        0% {
            clip: rect(44px, 9999px, 56px, 0);
            transform: skew(0.3deg);
        }

        10% {
            clip: rect(12px, 9999px, 80px, 0);
            transform: skew(0.8deg);
        }

        20% {
            clip: rect(65px, 9999px, 20px, 0);
            transform: skew(0.1deg);
        }

        30% {
            clip: rect(85px, 9999px, 95px, 0);
            transform: skew(0.5deg);
        }

        40% {
            clip: rect(30px, 9999px, 15px, 0);
            transform: skew(0.2deg);
        }

        50% {
            clip: rect(90px, 9999px, 40px, 0);
            transform: skew(0.6deg);
        }

        60% {
            clip: rect(10px, 9999px, 70px, 0);
            transform: skew(0.3deg);
        }

        70% {
            clip: rect(50px, 9999px, 25px, 0);
            transform: skew(0.7deg);
        }

        80% {
            clip: rect(25px, 9999px, 60px, 0);
            transform: skew(0.2deg);
        }

        90% {
            clip: rect(75px, 9999px, 90px, 0);
            transform: skew(0.4deg);
        }

        100% {
            clip: rect(35px, 9999px, 10px, 0);
            transform: skew(0.3deg);
        }
    }

    @keyframes glitch-anim-2 {
        0% {
            clip: rect(25px, 9999px, 90px, 0);
            transform: skew(0.4deg);
        }

        15% {
            clip: rect(70px, 9999px, 15px, 0);
            transform: skew(0.2deg);
        }

        30% {
            clip: rect(10px, 9999px, 60px, 0);
            transform: skew(0.6deg);
        }

        45% {
            clip: rect(50px, 9999px, 30px, 0);
            transform: skew(0.1deg);
        }

        60% {
            clip: rect(95px, 9999px, 75px, 0);
            transform: skew(0.5deg);
        }

        75% {
            clip: rect(30px, 9999px, 45px, 0);
            transform: skew(0.8deg);
        }

        90% {
            clip: rect(80px, 9999px, 10px, 0);
            transform: skew(0.3deg);
        }

        100% {
            clip: rect(15px, 9999px, 85px, 0);
            transform: skew(0.4deg);
        }
    }
    </style>
</head>

<body>
    <div class="scanlines"></div>
    <div class="ambient-glow"></div>
    <canvas id="cyberCanvas"></canvas>

    <!-- Top Header Navigation -->
    <header class="cyber-header">
        <a href="{{ url('/') }}" class="brand-box" title="Kembali ke Beranda Nemo Security Lab">
            <div class="brand-logo-hex">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <path d="M12 8v4" />
                    <path d="M12 16h.01" />
                </svg>
            </div>
            <div class="brand-title">
                <span>SecureOps</span>
                <span class="brand-subtitle">Nemo Security Lab</span>
            </div>
        </a>

        <div class="header-tools">
            <button class="tool-btn" id="soundToggleBtn" onclick="toggleAudio()"
                title="Nyalakan/Matikan Efek Suara Sci-Fi">
                <span id="soundIcon">🔇</span> <span id="soundLabel">Sound Off</span>
            </button>
            <button class="tool-btn" onclick="openGame()" title="Bosan nunggu? Mainkan Cyber Bug Catcher!">
                <span>🎮</span> <span>Mini Game</span>
            </button>
        </div>
    </header>

    <!-- Main Stage Content -->
    <main class="main-stage">
        <div class="cyber-card">
            <!-- Tech corner borders -->
            <div class="corner-tl"></div>
            <div class="corner-tr"></div>
            <div class="corner-bl"></div>
            <div class="corner-br"></div>

            <!-- Left Visual Column -->
            <div class="visual-column">
                <div class="art-stage">
                    <div class="art-ring-outer"></div>
                    <div class="art-ring-inner"></div>
                    <div class="art-radar-sweep"></div>
                    <div class="art-center-glyph">
                        @yield('icon')
                    </div>
                </div>

                <div class="glitch-code-wrapper">
                    <div class="glitch-code" data-text="@yield('code', '404')">@yield('code', '404')</div>
                </div>
            </div>

            <!-- Right Content Column -->
            <div class="content-column">
                <div class="status-badge-row">
                    <div class="cyber-badge">
                        <span class="pulse-dot"></span>
                        <span>@yield('status_badge', 'SYSTEM_ANOMALY_DETECTED')</span>
                    </div>
                    <span class="incident-badge">ID: <code
                            id="incidentHash">INC-{{ strtoupper(substr(md5(url()->current() . date('YmdH')), 0, 8)) }}</code></span>
                </div>

                <h1 class="error-heading">@yield('heading', 'Terjadi Gangguan Pada Sistem')</h1>
                <p class="error-subheading">@yield('description', 'Halaman atau endpoint yang Anda tuju tidak dapat
                    diproses saat ini.')</p>

                <div class="humor-quote">
                    @yield('humor', '"Di balik setiap error 404, ada server yang sedang menatap kosong ke kegelapan
                    subnet."')
                </div>

                <!-- Action Button Group -->
                <div class="btn-group">
                    <button type="button" class="btn-cyber-primary" onclick="openGame()">
                        <span>🎮</span>
                        <span>Mainkan Mini Game (Arahkan Drone)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Diagnostics Information Bar -->
        <div class="diag-bar">
            <div class="diag-items">
                <div class="diag-item">URL: <span id="diagUrl">{{ request()->fullUrl() }}</span></div>
                <div class="diag-item">WAKTU: <span id="diagTime">{{ now()->format('Y-m-d H:i:s') }} UTC</span></div>
                <div class="diag-item">PROTOKOL: <span>HTTP/2.0 TLS_AES</span></div>
            </div>
            <button class="copy-diag-btn" onclick="copyDiagnosticReport()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                </svg>
                <span>Salin Info Diagnostik</span>
            </button>
        </div>
    </main>

    <!-- Error Switcher / Preview Bar (Sangat berguna saat pengujian & demonstrasi) -->
    <nav class="error-switcher" aria-label="Error Code Previewer">
        <span class="switcher-label">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path d="m10 15 5-3-5-3v6z" />
            </svg>
            <span>Uji Status Error:</span>
        </span>
        <a href="{{ route('error.preview', ['code' => 404]) }}"
            class="switch-chip @if(request()->is('*/404') || (isset($code) && $code == 404)) active @endif">404 (Not
            Found)</a>
        <a href="{{ route('error.preview', ['code' => 403]) }}"
            class="switch-chip @if(request()->is('*/403') || (isset($code) && $code == 403)) active @endif">403
            (Forbidden)</a>
        <a href="{{ route('error.preview', ['code' => 500]) }}"
            class="switch-chip @if(request()->is('*/500') || (isset($code) && $code == 500)) active @endif">500 (Server
            Error)</a>
        <a href="{{ route('error.preview', ['code' => 503]) }}"
            class="switch-chip @if(request()->is('*/503') || (isset($code) && $code == 503)) active @endif">503
            (Maintenance)</a>
        <a href="{{ route('error.preview', ['code' => 419]) }}"
            class="switch-chip @if(request()->is('*/419') || (isset($code) && $code == 419)) active @endif">419 (Page
            Expired)</a>
        <a href="{{ route('error.preview', ['code' => 429]) }}"
            class="switch-chip @if(request()->is('*/429') || (isset($code) && $code == 429)) active @endif">429 (Too
            Many Requests)</a>
        <a href="{{ route('error.preview', ['code' => 401]) }}"
            class="switch-chip @if(request()->is('*/401') || (isset($code) && $code == 401)) active @endif">401
            (Unauthorized)</a>
    </nav>



    <!-- Modal: Playable Cyber Bug Catcher Mini Game -->
    <div class="cyber-modal-overlay" id="gameModal" onclick="handleModalBackdropClick(event, 'gameModal')">
        <div class="cyber-modal">
            <div class="modal-header">
                <div class="modal-title">
                    <span>👾 NEMO BUG CATCHER // DEFENSE DRONE PROTOCOL</span>
                </div>
                <button class="modal-close-btn" onclick="closeGame()" title="Tutup Game">&times;</button>
            </div>
            <div class="game-body">
                <div class="game-hud">
                    <div class="game-hud-stat">SKOR: <span id="gameScore">0</span></div>
                    <div class="game-hud-stat"
                        style="background:rgba(6,182,212,0.18);border:1px solid rgba(6,182,212,0.4);color:#38bdf8;">
                        🎯 <span style="color:#f1f5f9;font-weight:600;">Sentuh Target dengan Drone</span>
                    </div>
                    <div class="game-hud-stat">PERISAI: <span id="gameLivesDisplay">🛡️🛡️🛡️🛡️🛡️</span></div>
                    <div class="game-hud-stat">REKOR: <span id="gameHighScore">0</span></div>
                </div>
                <canvas id="gameCanvas"></canvas>

                <div class="game-overlay-msg" id="gameOverScreen" style="display: none;">
                    <h2 style="color: #ef4444; font-family: var(--font-mono); font-size: 1.5rem;">PERIMETER KEBOBOLAN!</h2>
                    <p style="color: #cbd5e1; font-size: 0.95rem;">Anomali siber menembus batas perisai lab.</p>
                    <div
                        style="font-family: var(--font-mono); color: var(--accent-cyan); font-size: 1.15rem; margin: 0.5rem 0;">
                        Skor Akhir: <span id="finalScoreVal">0</span>
                    </div>
                    <button class="btn-cyber-primary" onclick="restartGame()">
                        <span>🔄 Main Lagi (Santai & Perlahan)</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-msg" id="toastBox">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
            <polyline points="20 6 9 17 4 12" />
        </svg>
        <span id="toastText">Berhasil disalin!</span>
    </div>

    <!-- Scripts: Canvas Grid Animation, Audio Synth, Terminal CLI, & Bug Game -->
    <script>
    /* ----------------------------------------------------
     * 1. Audio Synthesizer (Web Audio API - Pure Vanilla)
     * ---------------------------------------------------- */
    let audioCtx = null;
    let soundEnabled = false;

    function initAudio() {
        if (!audioCtx) {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (AudioContext) {
                audioCtx = new AudioContext();
            }
        }
    }

    function toggleAudio() {
        initAudio();
        if (audioCtx && audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
        soundEnabled = !soundEnabled;
        const icon = document.getElementById('soundIcon');
        const label = document.getElementById('soundLabel');
        const btn = document.getElementById('soundToggleBtn');
        if (soundEnabled) {
            icon.textContent = '🔊';
            label.textContent = 'Sound ON';
            btn.classList.add('active');
            playSuccess();
            showToast('Efek Suara Sci-Fi Diaktifkan!');
        } else {
            icon.textContent = '🔇';
            label.textContent = 'Sound OFF';
            btn.classList.remove('active');
            showToast('Efek Suara Dimatikan');
        }
    }

    function playBeep(freq = 520, type = 'sine', duration = 0.08) {
        if (!soundEnabled || !audioCtx) return;
        try {
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = type;
            osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.08, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + duration);
        } catch (e) {}
    }

    function playLaser() {
        if (!soundEnabled || !audioCtx) return;
        try {
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sawtooth';
            osc.frequency.setValueAtTime(880, audioCtx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(110, audioCtx.currentTime + 0.12);
            gain.gain.setValueAtTime(0.12, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.12);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.12);
        } catch (e) {}
    }

    function playSuccess() {
        if (!soundEnabled || !audioCtx) return;
        try {
            const now = audioCtx.currentTime;
            [440, 554.37, 659.25].forEach((freq, idx) => {
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(freq, now + (idx * 0.07));
                gain.gain.setValueAtTime(0.08, now + (idx * 0.07));
                gain.gain.exponentialRampToValueAtTime(0.001, now + (idx * 0.07) + 0.18);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start(now + (idx * 0.07));
                osc.stop(now + (idx * 0.07) + 0.18);
            });
        } catch (e) {}
    }

    /* ----------------------------------------------------
     * 2. Canvas Background Matrix / Cyber Grid Particles
     * ---------------------------------------------------- */
    const canvas = document.getElementById('cyberCanvas');
    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];
    let mouseX = -1000,
        mouseY = -1000;
    let isMatrixMode = false;
    let matrixChars = '0123456789ABCDEF<>/*&^%$#@!NEMOSECOPS';
    let matrixDrops = [];

    function resizeCanvas() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        initParticles();
        initMatrixDrops();
    }

    function initParticles() {
        particles = [];
        const count = Math.min(Math.floor((width * height) / 18000), 75);
        for (let i = 0; i < count; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.6,
                vy: (Math.random() - 0.5) * 0.6,
                size: Math.random() * 2 + 1,
                alpha: Math.random() * 0.5 + 0.2
            });
        }
    }

    function initMatrixDrops() {
        const columns = Math.floor(width / 20);
        matrixDrops = [];
        for (let i = 0; i < columns; i++) {
            matrixDrops[i] = Math.floor(Math.random() * -50);
        }
    }

    window.addEventListener('resize', resizeCanvas);
    window.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    function renderCanvas() {
        ctx.clearRect(0, 0, width, height);

        if (isMatrixMode) {
            // Digital Matrix Rain Mode
            ctx.fillStyle = 'rgba(6, 8, 14, 0.2)';
            ctx.fillRect(0, 0, width, height);
            ctx.fillStyle = '#10b981';
            ctx.font = '14px monospace';

            for (let i = 0; i < matrixDrops.length; i++) {
                const char = matrixChars[Math.floor(Math.random() * matrixChars.length)];
                const x = i * 20;
                const y = matrixDrops[i] * 20;

                ctx.fillText(char, x, y);

                if (y > height && Math.random() > 0.975) {
                    matrixDrops[i] = 0;
                }
                matrixDrops[i]++;
            }
        } else {
            // Constellation Cyber Node Network
            for (let i = 0; i < particles.length; i++) {
                const p = particles[i];
                p.x += p.vx;
                p.y += p.vy;

                if (p.x < 0) p.x = width;
                if (p.x > width) p.x = 0;
                if (p.y < 0) p.y = height;
                if (p.y > height) p.y = 0;

                // Mouse proximity interaction
                const dx = mouseX - p.x;
                const dy = mouseY - p.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    p.x -= dx * 0.02;
                    p.y -= dy * 0.02;
                }

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(56, 189, 248, ${p.alpha})`;
                ctx.fill();

                // Connect lines to close nodes
                for (let j = i + 1; j < particles.length; j++) {
                    const p2 = particles[j];
                    const d = Math.hypot(p.x - p2.x, p.y - p2.y);
                    if (d < 110) {
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.strokeStyle = `rgba(56, 189, 248, ${0.15 * (1 - d / 110)})`;
                        ctx.lineWidth = 0.8;
                        ctx.stroke();
                    }
                }
            }
        }

        requestAnimationFrame(renderCanvas);
    }

    resizeCanvas();
    requestAnimationFrame(renderCanvas);

    /* ----------------------------------------------------
     * 3. Toast & Diagnostics Tool
     * ---------------------------------------------------- */
    function showToast(text) {
        const toast = document.getElementById('toastBox');
        const label = document.getElementById('toastText');
        label.textContent = text;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    function copyDiagnosticReport() {
        playBeep(600, 'sine', 0.1);
        const inc = document.getElementById('incidentHash').innerText;
        const url = window.location.href;
        const time = new Date().toISOString();
        const report =
            `[NEMO_SECOPS_ERROR_REPORT]\nIncident ID: ${inc}\nURL: ${url}\nTimestamp: ${time}\nUser-Agent: ${navigator.userAgent}\nStatus: @yield('code', '404') - @yield('status_badge', 'ANOMALY')`;

        navigator.clipboard.writeText(report).then(() => {
            showToast('Laporan diagnostik berhasil disalin ke clipboard!');
            playSuccess();
        }).catch(() => {
            showToast('Gagal menyalin otomatis, silakan salin manual.');
        });
    }



    /* ----------------------------------------------------
     * 5. Playable Bug Catcher Arcade Mini Game (DEFENSE DRONE - CLEAR & RELAXED)
     * ---------------------------------------------------- */
    const gCanvas = document.getElementById('gameCanvas');
    const gCtx = gCanvas.getContext('2d');
    let gameScore = 0;
    let gameLives = 5;
    let gameHighScore = parseInt(localStorage.getItem('nemo_game_highscore') || '0', 10);
    let gameActive = false;
    let gameBugs = [];
    let gameParticles = [];
    let gameFloatingTexts = [];
    let gameShockwaves = [];
    let gameSpawnTimer = 0;
    let gameAnimFrame = null;

    // Player Defense Drone
    let droneX = 0;
    let droneY = 0;
    let droneTargetX = 0;
    let droneTargetY = 0;
    let droneRadius = 48; // Large, generous capture radius
    let droneAngle = 0;
    let dronePulseWave = 10;

    document.getElementById('gameHighScore').textContent = gameHighScore;

    function updateLivesDisplay() {
        const el = document.getElementById('gameLivesDisplay');
        if (el) {
            el.textContent = '🛡️'.repeat(Math.max(0, gameLives)) + ` (${gameLives}/5)`;
            if (gameLives <= 1) {
                el.style.color = '#ef4444';
            } else {
                el.style.color = '#38bdf8';
            }
        }
    }

    function openGame() {
        playBeep(520, 'sine', 0.1);
        document.getElementById('gameModal').classList.add('active');
        resizeGameCanvas();
        startGame();
    }

    function closeGame() {
        playBeep(320, 'sine', 0.08);
        gameActive = false;
        cancelAnimationFrame(gameAnimFrame);
        document.getElementById('gameModal').classList.remove('active');
    }

    function resizeGameCanvas() {
        const rect = gCanvas.parentElement.getBoundingClientRect();
        gCanvas.width = rect.width;
        gCanvas.height = rect.height;
        if (droneX === 0) {
            droneX = droneTargetX = gCanvas.width / 2;
            droneY = droneTargetY = gCanvas.height - 90;
        }
    }

    function startGame() {
        gameActive = true;
        gameScore = 0;
        gameLives = 5;
        gameBugs = [];
        gameParticles = [];
        gameFloatingTexts = [];
        gameShockwaves = [];
        gameSpawnTimer = 0;
        droneX = droneTargetX = gCanvas.width / 2;
        droneY = droneTargetY = gCanvas.height - 90;
        document.getElementById('gameScore').textContent = '0';
        updateLivesDisplay();
        document.getElementById('gameOverScreen').style.display = 'none';
        loopGame();
    }

    function restartGame() {
        playBeep(600, 'sine', 0.1);
        startGame();
    }

    function spawnBug() {
        // High-contrast, large, clearly visible cyber targets with balanced arcade speeds
        const types = [
            {
                name: 'Malware Worm',
                emoji: '🐛',
                points: 10,
                speed: 1.15,       // Gerakan pas, jelas terlihat dan tidak lemot
                r: 28,             // Ukuran besar (diameter 56px)
                color: '#10b981',  // Hijau neon terang
                badge: '+10 PTS'
            },
            {
                name: 'Trojan Bot',
                emoji: '👾',
                points: 25,
                speed: 1.45,       // Sedang dan dinamis
                r: 30,             // Ukuran besar (diameter 60px)
                color: '#ef4444',  // Merah neon menyala
                badge: '+25 PTS'
            },
            {
                name: 'Ransomware Spike',
                emoji: '⚡',
                points: 50,
                speed: 1.75,       // Lebih gesit namun tetap nyaman dikejar
                r: 28,             // Ukuran besar (diameter 56px)
                color: '#f59e0b',  // Emas/kuning neon
                badge: '+50 PTS'
            }
        ];

        const chosen = types[Math.floor(Math.random() * types.length)];
        const balancedSpeed = chosen.speed + Math.min(gameScore * 0.005, 0.5); // Penambahan speed seimbang

        gameBugs.push({
            x: Math.random() * (gCanvas.width - 120) + 60,
            y: -40,
            emoji: chosen.emoji,
            points: chosen.points,
            speed: balancedSpeed,
            r: chosen.r,
            color: chosen.color,
            badge: chosen.badge,
            pulse: 0,
            trail: []
        });
    }

    function createExplosion(x, y, color = '#38bdf8') {
        // Shockwave ring
        gameShockwaves.push({
            x: x,
            y: y,
            radius: 12,
            maxRadius: 52,
            alpha: 1,
            color: color
        });

        // Sparks
        for (let i = 0; i < 14; i++) {
            const angle = (Math.PI * 2 / 14) * i + Math.random() * 0.3;
            const spd = Math.random() * 2.8 + 1.5;
            gameParticles.push({
                x: x,
                y: y,
                vx: Math.cos(angle) * spd,
                vy: Math.sin(angle) * spd,
                radius: Math.random() * 3.5 + 2,
                alpha: 1,
                color: color
            });
        }
    }

    function createFloatingText(x, y, text, color = '#38bdf8') {
        gameFloatingTexts.push({
            x: x,
            y: y,
            text: text,
            color: color,
            alpha: 1,
            vy: -1.0
        });
    }

    function loopGame() {
        if (!gameActive) return;

        gCtx.clearRect(0, 0, gCanvas.width, gCanvas.height);

        // 1. Draw subtle tactical grid background
        drawTacticalGrid();

        // 2. Smooth drone navigation towards mouse/finger (more responsive)
        droneX += (droneTargetX - droneX) * 0.5;
        droneY += (droneTargetY - droneY) * 0.5;
        droneAngle += 0.04;
        dronePulseWave += 0.8;
        if (dronePulseWave > 70) dronePulseWave = 15;

        // 3. Spawn targets at engaging, steady intervals
        gameSpawnTimer++;
        if (gameSpawnTimer % Math.max(42, 62 - Math.floor(gameScore / 25)) === 0) {
            spawnBug();
        }

        // 4. Update & draw falling targets
        for (let i = gameBugs.length - 1; i >= 0; i--) {
            const b = gameBugs[i];
            b.y += b.speed;
            b.pulse += 0.05;

            // Update trail
            b.trail.unshift({ x: b.x, y: b.y });
            if (b.trail.length > 5) b.trail.pop();

            // Check collision with drone (AUTOMATIC VAPORIZATION)
            const dist = Math.hypot(droneX - b.x, droneY - b.y);
            if (dist < (droneRadius + b.r)) {
                // Hit!
                playLaser();
                gameScore += b.points;
                document.getElementById('gameScore').textContent = gameScore;

                createExplosion(b.x, b.y, b.color);
                createFloatingText(b.x, b.y - 15, `${b.badge}!`, b.color);

                gameBugs.splice(i, 1);
                continue;
            }

            // Draw target pod
            drawTargetPod(b);

            // Check bottom breach
            if (b.y > gCanvas.height + 35) {
                gameBugs.splice(i, 1);
                gameLives--;
                updateLivesDisplay();
                playBeep(190, 'sawtooth', 0.2);

                // Warning red flash edge
                gCtx.fillStyle = 'rgba(239, 68, 68, 0.25)';
                gCtx.fillRect(0, 0, gCanvas.width, gCanvas.height);

                if (gameLives <= 0) {
                    endGame();
                    return;
                }
            }
        }

        // 5. Update & draw shockwaves
        for (let i = gameShockwaves.length - 1; i >= 0; i--) {
            const sw = gameShockwaves[i];
            sw.radius += 2.2;
            sw.alpha -= 0.045;
            if (sw.alpha <= 0) {
                gameShockwaves.splice(i, 1);
                continue;
            }
            gCtx.save();
            gCtx.beginPath();
            gCtx.arc(sw.x, sw.y, sw.radius, 0, Math.PI * 2);
            gCtx.strokeStyle = sw.color;
            gCtx.lineWidth = 2.5;
            gCtx.globalAlpha = sw.alpha;
            gCtx.stroke();
            gCtx.restore();
        }

        // 6. Update & draw spark particles
        for (let i = gameParticles.length - 1; i >= 0; i--) {
            const p = gameParticles[i];
            p.x += p.vx;
            p.y += p.vy;
            p.alpha -= 0.035;

            if (p.alpha <= 0) {
                gameParticles.splice(i, 1);
                continue;
            }

            gCtx.save();
            gCtx.beginPath();
            gCtx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            gCtx.fillStyle = p.color;
            gCtx.shadowColor = p.color;
            gCtx.shadowBlur = 8;
            gCtx.globalAlpha = p.alpha;
            gCtx.fill();
            gCtx.restore();
        }

        // 7. Update & draw floating score texts
        for (let i = gameFloatingTexts.length - 1; i >= 0; i--) {
            const ft = gameFloatingTexts[i];
            ft.y += ft.vy;
            ft.alpha -= 0.025;

            if (ft.alpha <= 0) {
                gameFloatingTexts.splice(i, 1);
                continue;
            }

            gCtx.save();
            gCtx.font = 'bold 15px monospace';
            gCtx.fillStyle = ft.color;
            gCtx.shadowColor = ft.color;
            gCtx.shadowBlur = 10;
            gCtx.globalAlpha = ft.alpha;
            gCtx.textAlign = 'center';
            gCtx.fillText(ft.text, ft.x, ft.y);
            gCtx.restore();
        }

        // 8. Draw Player Cyber Defense Drone
        drawPlayerDrone(droneX, droneY, droneAngle, dronePulseWave);

        gameAnimFrame = requestAnimationFrame(loopGame);
    }

    function drawTacticalGrid() {
        gCtx.save();
        gCtx.strokeStyle = 'rgba(56, 189, 248, 0.04)';
        gCtx.lineWidth = 1;

        const step = 45;
        for (let x = 0; x < gCanvas.width; x += step) {
            gCtx.beginPath();
            gCtx.moveTo(x, 0);
            gCtx.lineTo(x, gCanvas.height);
            gCtx.stroke();
        }
        for (let y = 0; y < gCanvas.height; y += step) {
            gCtx.beginPath();
            gCtx.moveTo(0, y);
            gCtx.lineTo(gCanvas.width, y);
            gCtx.stroke();
        }
        gCtx.restore();
    }

    function drawTargetPod(b) {
        gCtx.save();

        // Fading comet trail
        if (b.trail && b.trail.length > 1) {
            for (let t = 1; t < b.trail.length; t++) {
                const tr = b.trail[t];
                const trailAlpha = (1 - t / b.trail.length) * 0.35;
                gCtx.beginPath();
                gCtx.arc(tr.x, tr.y, b.r * (1 - t * 0.15), 0, Math.PI * 2);
                gCtx.fillStyle = b.color;
                gCtx.globalAlpha = trailAlpha;
                gCtx.fill();
            }
        }

        gCtx.globalAlpha = 1;

        // Outer glowing shadow
        gCtx.shadowColor = b.color;
        gCtx.shadowBlur = 16;

        // Dark circular core pod
        gCtx.beginPath();
        gCtx.arc(b.x, b.y, b.r, 0, Math.PI * 2);
        gCtx.fillStyle = 'rgba(8, 14, 26, 0.95)';
        gCtx.fill();

        // Glowing border ring
        gCtx.lineWidth = 3;
        gCtx.strokeStyle = b.color;
        gCtx.stroke();

        // Pulsing warning energy halo
        gCtx.beginPath();
        gCtx.arc(b.x, b.y, b.r + Math.sin(b.pulse) * 3, 0, Math.PI * 2);
        gCtx.strokeStyle = b.color;
        gCtx.lineWidth = 1.2;
        gCtx.globalAlpha = 0.55;
        gCtx.stroke();

        // Reset shadow for crisp text/icon
        gCtx.shadowBlur = 0;
        gCtx.globalAlpha = 1;

        // Centered large emoji icon
        gCtx.font = '26px sans-serif';
        gCtx.textAlign = 'center';
        gCtx.textBaseline = 'middle';
        gCtx.fillText(b.emoji, b.x, b.y - 2);

        // Tech score badge below
        gCtx.font = 'bold 11px monospace';
        gCtx.fillStyle = b.color;
        gCtx.fillText(b.badge, b.x, b.y + b.r + 14);

        gCtx.restore();
    }

    function drawPlayerDrone(x, y, angle, pulseWave) {
        gCtx.save();
        gCtx.translate(x, y);

        // Expanding radar pulse wave
        gCtx.beginPath();
        gCtx.arc(0, 0, pulseWave, 0, Math.PI * 2);
        gCtx.strokeStyle = '#38bdf8';
        gCtx.lineWidth = 1.5;
        gCtx.globalAlpha = Math.max(0, 1 - pulseWave / 70) * 0.45;
        gCtx.stroke();

        gCtx.globalAlpha = 1;

        // Ambient glow aura (clear capture area indicator)
        const grad = gCtx.createRadialGradient(0, 0, 8, 0, 0, droneRadius + 8);
        grad.addColorStop(0, 'rgba(6, 182, 212, 0.35)');
        grad.addColorStop(0.7, 'rgba(6, 182, 212, 0.12)');
        grad.addColorStop(1, 'transparent');
        gCtx.beginPath();
        gCtx.arc(0, 0, droneRadius + 8, 0, Math.PI * 2);
        gCtx.fillStyle = grad;
        gCtx.fill();

        // Rotating outer dashed defense shield
        gCtx.rotate(angle);
        gCtx.beginPath();
        gCtx.arc(0, 0, droneRadius, 0, Math.PI * 2);
        gCtx.setLineDash([10, 8]);
        gCtx.strokeStyle = '#38bdf8';
        gCtx.lineWidth = 2.5;
        gCtx.shadowColor = '#38bdf8';
        gCtx.shadowBlur = 12;
        gCtx.stroke();
        gCtx.setLineDash([]);
        gCtx.shadowBlur = 0;

        // Inner counter-rotating tactical ring
        gCtx.rotate(-angle * 2.2);
        gCtx.beginPath();
        gCtx.arc(0, 0, droneRadius * 0.62, 0, Math.PI * 2);
        gCtx.strokeStyle = 'rgba(255, 255, 255, 0.85)';
        gCtx.lineWidth = 1.8;
        gCtx.stroke();

        // Crosshairs with sci-fi notches
        gCtx.beginPath();
        gCtx.moveTo(-droneRadius - 6, 0); gCtx.lineTo(-droneRadius + 8, 0);
        gCtx.moveTo(droneRadius - 8, 0);  gCtx.lineTo(droneRadius + 6, 0);
        gCtx.moveTo(0, -droneRadius - 6); gCtx.lineTo(0, -droneRadius + 8);
        gCtx.moveTo(0, droneRadius - 8);  gCtx.lineTo(0, droneRadius + 6);
        gCtx.strokeStyle = '#06b6d4';
        gCtx.lineWidth = 2.5;
        gCtx.stroke();

        // Center plasma core emitter
        gCtx.beginPath();
        gCtx.arc(0, 0, 6, 0, Math.PI * 2);
        gCtx.fillStyle = '#ffffff';
        gCtx.shadowColor = '#06b6d4';
        gCtx.shadowBlur = 10;
        gCtx.fill();

        gCtx.restore();
    }

    function endGame() {
        gameActive = false;
        cancelAnimationFrame(gameAnimFrame);
        playBeep(180, 'sawtooth', 0.3);
        if (gameScore > gameHighScore) {
            gameHighScore = gameScore;
            localStorage.setItem('nemo_game_highscore', gameHighScore.toString());
            document.getElementById('gameHighScore').textContent = gameHighScore;
        }
        document.getElementById('finalScoreVal').textContent = gameScore;
        document.getElementById('gameOverScreen').style.display = 'flex';
    }

    // Steer with mouse movement (NO CLICKING REQUIRED)
    gCanvas.addEventListener('mousemove', function(e) {
        const rect = gCanvas.getBoundingClientRect();
        droneTargetX = Math.max(droneRadius, Math.min(gCanvas.width - droneRadius, e.clientX - rect.left));
        droneTargetY = Math.max(droneRadius, Math.min(gCanvas.height - droneRadius, e.clientY - rect.top));
    });

    // Steer with touch movement for mobile / touchscreens
    gCanvas.addEventListener('touchmove', function(e) {
        e.preventDefault();
        if (e.touches && e.touches[0]) {
            const rect = gCanvas.getBoundingClientRect();
            droneTargetX = Math.max(droneRadius, Math.min(gCanvas.width - droneRadius, e.touches[0].clientX - rect.left));
            droneTargetY = Math.max(droneRadius, Math.min(gCanvas.height - droneRadius, e.touches[0].clientY - rect.top));
        }
    }, {
        passive: false
    });

    function handleModalBackdropClick(event, modalId) {
        if (event.target.id === modalId) {
            if (modalId === 'gameModal') closeGame();
        }
    }
    </script>
</body>

</html>