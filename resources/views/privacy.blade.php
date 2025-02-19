@extends('layouts.app')
@section('content')

<head>
    <script data-no-optimize="1">
    var litespeed_docref = sessionStorage.getItem("litespeed_docref");
    litespeed_docref && (Object.defineProperty(document, "referrer", {
        get: function() {
            return litespeed_docref
        }
    }), sessionStorage.removeItem("litespeed_docref"));
    </script>
    <meta charset="UTF-8" />
    <style id="litespeed-ccss">
    :root {
        --joinchat-ico: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23fff' d='M3.516 3.516c4.686-4.686 12.284-4.686 16.97 0s4.686 12.283 0 16.97a12 12 0 0 1-13.754 2.299l-5.814.735a.392.392 0 0 1-.438-.44l.748-5.788A12 12 0 0 1 3.517 3.517zm3.61 17.043.3.158a9.85 9.85 0 0 0 11.534-1.758c3.843-3.843 3.843-10.074 0-13.918s-10.075-3.843-13.918 0a9.85 9.85 0 0 0-1.747 11.554l.16.303-.51 3.942a.196.196 0 0 0 .219.22zm6.534-7.003-.933 1.164a9.84 9.84 0 0 1-3.497-3.495l1.166-.933a.79.79 0 0 0 .23-.94L9.561 6.96a.79.79 0 0 0-.924-.445l-2.023.524a.797.797 0 0 0-.588.88 11.754 11.754 0 0 0 10.005 10.005.797.797 0 0 0 .88-.587l.525-2.023a.79.79 0 0 0-.445-.923L14.6 13.327a.79.79 0 0 0-.94.23z'/%3E%3C/svg%3E");
        --joinchat-font: -apple-system, blinkmacsystemfont, "Segoe UI", roboto, oxygen-sans, ubuntu, cantarell, "Helvetica Neue", sans-serif
    }

    .joinchat {
        --bottom: 20px;
        --sep: 20px;
        --s: 60px;
        --header: calc(var(--s)*1.16667);
        --vh: 100vh;
        --red: 37;
        --green: 211;
        --blue: 102;
        --rgb: var(--red) var(--green) var(--blue);
        --color: rgb(var(--rgb));
        --dark: rgb(calc(var(--red) - 75) calc(var(--green) - 75) calc(var(--blue) - 75));
        --hover: rgb(calc(var(--red) + 50) calc(var(--green) + 50) calc(var(--blue) + 50));
        --bg: rgb(var(--rgb)/4%);
        --bw: 100;
        --text: hsl(0deg 0% clamp(0%, var(--bw)*1%, 100%)/clamp(70%, var(--bw)*1%, 100%));
        --msg: var(--color);
        color: var(--text);
        display: none;
        position: fixed;
        z-index: 9000;
        right: var(--sep);
        bottom: var(--bottom);
        font: normal normal normal 16px/1.625em var(--joinchat-font);
        letter-spacing: 0;
        animation: joinchat_show .5s cubic-bezier(.18, .89, .32, 1.28) 10ms both;
        transform: scale3d(0, 0, 0);
        transform-origin: calc(var(--s)/-2) calc(var(--s)/-4);
        touch-action: manipulation;
        -webkit-font-smoothing: antialiased
    }

    .joinchat *,
    .joinchat :after,
    .joinchat :before {
        box-sizing: border-box
    }

    @supports not (width:clamp(1px, 1%, 10px)) {
        .joinchat {
            --text: hsl(0deg 0% calc(var(--bw)*1%)/90%)
        }
    }

    .joinchat__button {
        display: flex;
        flex-direction: row;
        position: absolute;
        z-index: 2;
        bottom: 8px;
        right: 8px;
        height: var(--s);
        min-width: var(--s);
        background: #25d366;
        color: inherit;
        border-radius: calc(var(--s)/2);
        box-shadow: 1px 6px 24px 0 rgba(7, 94, 84, .24)
    }

    .joinchat__button__open {
        width: var(--s);
        height: var(--s);
        border-radius: 50%;
        background: rgb(0 0 0/0) var(--joinchat-ico) 50% no-repeat;
        background-size: 60%;
        overflow: hidden
    }

    .joinchat__button__send {
        display: none;
        flex-shrink: 0;
        width: var(--s);
        height: var(--s);
        max-width: var(--s);
        padding: calc(var(--s)*0.18);
        margin: 0;
        overflow: hidden
    }

    .joinchat__button__send path {
        fill: none !important;
        stroke: var(--text) !important
    }

    .joinchat__button__send .joinchat_svg__plain {
        stroke-dasharray: 1097;
        stroke-dashoffset: 1097;
        animation: joinchat_plain 6s .2s ease-in-out infinite
    }

    .joinchat__button__send .joinchat_svg__chat {
        stroke-dasharray: 1020;
        stroke-dashoffset: 1020;
        animation: joinchat_chat 6s 3.2s ease-in-out infinite
    }

    .joinchat__button__sendtext {
        padding: 0;
        max-width: 0;
        border-radius: var(--s);
        font-weight: 600;
        line-height: var(--s);
        white-space: nowrap;
        opacity: 0;
        overflow: hidden;
        text-overflow: ellipsis
    }

    .joinchat__box {
        display: flex;
        flex-direction: column;
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 1;
        width: calc(100vw - var(--sep)*2);
        max-width: 400px;
        max-height: calc(var(--vh) - var(--bottom) - var(--sep));
        border-radius: calc(var(--s)/2 + 2px);
        background: #fff linear-gradient(180deg, var(--color), var(--color) var(--header), var(--bg) var(--header), var(--bg));
        box-shadow: 0 2px 6px 0 rgba(0, 0, 0, .5);
        text-align: left;
        overflow: hidden;
        transform: scale3d(0, 0, 0);
        opacity: 0
    }

    .joinchat__header {
        display: flex;
        flex-flow: row;
        align-items: center;
        position: relative;
        flex-shrink: 0;
        height: var(--header);
        min-height: 50px;
        padding: 0 70px 0 26px;
        margin: 0
    }

    .joinchat__powered {
        font-size: 11px;
        line-height: 18px;
        color: inherit !important;
        text-decoration: none !important;
        fill: currentcolor;
        opacity: .8
    }

    .joinchat__powered svg {
        display: inline-block;
        width: auto;
        height: 18px;
        vertical-align: -30%
    }

    .joinchat__close {
        --size: 34px;
        position: absolute;
        top: calc(50% - var(--size)/2);
        right: 24px;
        width: var(--size);
        height: var(--size);
        border-radius: 50%;
        background: rgba(0, 0, 0, .4) url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 24 24'%3E%3Cpath d='M24 2.4 21.6 0 12 9.6 2.4 0 0 2.4 9.6 12 0 21.6 2.4 24l9.6-9.6 9.6 9.6 2.4-2.4-9.6-9.6z'/%3E%3C/svg%3E") 50% no-repeat;
        background-size: 12px
    }

    .joinchat__box__scroll {
        overflow: hidden scroll;
        overscroll-behavior-y: contain;
        -webkit-overflow-scrolling: touch
    }

    .joinchat__box__scroll::-webkit-scrollbar {
        width: 4px;
        background: rgb(0 0 0/0)
    }

    .joinchat__box__scroll::-webkit-scrollbar-thumb {
        border-radius: 2px;
        background: rgb(0 0 0/0)
    }

    .joinchat__box__content {
        width: calc(100% + 4px);
        padding: 20px 0 calc(var(--s) + 16px)
    }

    .joinchat {
        --peak: url(#joinchat__peak_l)
    }

    .joinchat__message {
        position: relative;
        min-height: 56px;
        padding: 15px 20px;
        margin: 0 26px 26px;
        border-radius: 26px;
        background: #fff;
        color: #4a4a4a;
        word-break: break-word;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, .3));
        transform: translateZ(0)
    }

    .joinchat__message:before {
        content: "";
        display: block;
        position: absolute;
        bottom: 18px;
        left: -15px;
        width: 17px;
        height: 25px;
        background: inherit;
        -webkit-clip-path: var(--peak);
        clip-path: var(--peak)
    }

    @keyframes joinchat_show {
        0% {
            transform: scale3d(0, 0, 0)
        }

        to {
            transform: scaleX(1)
        }
    }

    @keyframes joinchat_plain {

        0%,
        50%,
        to {
            stroke-dashoffset: 1097
        }

        5%,
        45% {
            stroke-dashoffset: 0
        }
    }

    @keyframes joinchat_chat {

        0%,
        50%,
        to {
            stroke-dashoffset: 1020
        }

        5%,
        45% {
            stroke-dashoffset: 0
        }
    }

    @media (prefers-reduced-motion) {
        .joinchat {
            animation: none
        }

        .joinchat__button__send .joinchat_svg__plain {
            stroke-dasharray: 0;
            animation: none
        }

        .joinchat__button__send .joinchat_svg__chat {
            animation: none
        }
    }

    html {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        font-family: sans-serif
    }

    body {
        margin: 0
    }

    header,
    main,
    section {
        display: block
    }

    a {
        background-color: transparent
    }

    strong {
        font-weight: inherit;
        font-weight: bolder
    }

    img {
        border-style: none
    }

    svg:not(:root) {
        overflow: hidden
    }

    *,
    :after,
    :before,
    html {
        box-sizing: border-box
    }

    html {
        background-attachment: fixed
    }

    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #777
    }

    img {
        display: inline-block;
        height: auto;
        max-width: 100%;
        vertical-align: middle
    }

    a {
        touch-action: manipulation
    }

    .col {
        margin: 0;
        padding: 0 15px 30px;
        position: relative;
        width: 100%
    }

    .col-inner {
        background-position: 50% 50%;
        background-repeat: no-repeat;
        background-size: cover;
        flex: 1 0 auto;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        width: 100%
    }

    @media screen and (min-width:850px) {
        .col:first-child .col-inner {
            margin-left: auto;
            margin-right: 0
        }
    }

    @media screen and (max-width:849px) {
        .col {
            padding-bottom: 30px
        }
    }

    .small-12 {
        flex-basis: 100%;
        max-width: 100%
    }

    @media screen and (min-width:850px) {
        .large-12 {
            flex-basis: 100%;
            max-width: 100%
        }
    }

    .container,
    .row {
        margin-left: auto;
        margin-right: auto;
        width: 100%
    }

    .container {
        padding-left: 15px;
        padding-right: 15px
    }

    .container,
    .row {
        max-width: 1080px
    }

    .flex-row {
        align-items: center;
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        width: 100%
    }

    .header .flex-row {
        height: 100%
    }

    .flex-col {
        max-height: 100%
    }

    .flex-grow {
        -ms-flex-negative: 1;
        -ms-flex-preferred-size: auto !important;
        flex: 1
    }

    .flex-left {
        margin-right: auto
    }

    .flex-right {
        margin-left: auto
    }

    @media (-ms-high-contrast:none) {
        .nav>li>a>i {
            top: -1px
        }
    }

    .row {
        display: flex;
        flex-flow: row wrap;
        width: 100%
    }

    .section {
        align-items: center;
        display: flex;
        flex-flow: row;
        min-height: auto;
        padding: 30px 0;
        position: relative;
        width: 100%
    }

    .section-bg {
        overflow: hidden
    }

    .section-bg,
    .section-content {
        width: 100%
    }

    .section-content {
        z-index: 1
    }

    .nav {
        margin: 0;
        padding: 0
    }

    .nav {
        align-items: center;
        display: inline-block;
        display: flex;
        flex-flow: row wrap;
        width: 100%
    }

    .nav,
    .nav>li {
        position: relative
    }

    .nav>li {
        list-style: none;
        margin: 0 7px;
        padding: 0
    }

    .nav>li,
    .nav>li>a {
        display: inline-block
    }

    .nav>li>a {
        align-items: center;
        display: inline-flex;
        flex-wrap: wrap;
        padding: 10px 0
    }

    .nav-left {
        justify-content: flex-start
    }

    .nav-right {
        justify-content: flex-end
    }

    .nav>li>a {
        color: hsla(0, 0%, 40%, .85)
    }

    .nav li:first-child {
        margin-left: 0 !important
    }

    .nav li:last-child {
        margin-right: 0 !important
    }

    .nav-uppercase>li>a {
        font-weight: bolder;
        letter-spacing: .02em;
        text-transform: uppercase
    }

    .nav.nav-vertical {
        flex-flow: column
    }

    .nav.nav-vertical li {
        list-style: none;
        margin: 0;
        width: 100%
    }

    .nav-vertical>li {
        align-items: center;
        display: flex;
        flex-flow: row wrap
    }

    .nav-vertical>li>a {
        align-items: center;
        display: flex;
        flex-grow: 1;
        width: auto
    }

    .nav-sidebar.nav-vertical>li+li {
        border-top: 1px solid #ececec
    }

    .nav-vertical>li+li {
        border-top: 1px solid #ececec
    }

    .button {
        background-color: transparent;
        border: 1px solid transparent;
        border-radius: 0;
        box-sizing: border-box;
        color: currentColor;
        display: inline-block;
        font-size: .97em;
        font-weight: bolder;
        letter-spacing: .03em;
        line-height: 2.4em;
        margin-right: 1em;
        margin-top: 0;
        max-width: 100%;
        min-height: 2.5em;
        padding: 0 1.2em;
        position: relative;
        text-align: center;
        text-decoration: none;
        text-rendering: optimizeLegibility;
        text-shadow: none;
        text-transform: uppercase;
        vertical-align: middle
    }

    .button.is-outline {
        line-height: 2.19em
    }

    .button {
        background-color: var(--fs-color-primary);
        border-color: rgba(0, 0, 0, .05);
        color: #fff
    }

    .button.is-outline {
        background-color: transparent;
        border: 2px solid
    }

    .is-outline {
        color: silver
    }

    i[class^=icon-] {
        speak: none !important;
        display: inline-block;
        font-display: block;
        font-family: fl-icons !important;
        font-style: normal !important;
        font-variant: normal !important;
        font-weight: 400 !important;
        line-height: 1.2;
        margin: 0;
        padding: 0;
        position: relative;
        text-transform: none !important
    }

    .button i {
        top: -1.5px;
        vertical-align: middle
    }

    .button.icon {
        display: inline-block;
        margin-left: .12em;
        margin-right: .12em;
        min-width: 2.5em;
        padding-left: .6em;
        padding-right: .6em
    }

    .button.icon i {
        font-size: 1.2em
    }

    .button.icon.circle {
        padding-left: 0;
        padding-right: 0
    }

    .button.icon.circle>i {
        margin: 0 8px
    }

    .button.icon.circle>i:only-child {
        margin: 0
    }

    .nav>li>a>i {
        font-size: 20px;
        vertical-align: middle
    }

    .nav>li>a>i.icon-menu {
        font-size: 1.9em
    }

    .nav>li.has-icon>a>i {
        min-width: 1em
    }

    img {
        opacity: 1
    }

    .mfp-hide {
        display: none !important
    }

    a {
        color: var(--fs-experimental-link-color);
        text-decoration: none
    }

    a.plain {
        color: currentColor
    }

    ul {
        list-style: disc
    }

    ul {
        margin-top: 0;
        padding: 0
    }

    li {
        margin-bottom: .6em
    }

    .col-inner ul li {
        margin-left: 1.3em
    }

    .button {
        margin-bottom: 1em
    }

    p,
    ul {
        margin-bottom: 1.3em
    }

    body {
        line-height: 1.6
    }

    h3 {
        color: #555;
        margin-bottom: .5em;
        margin-top: 0;
        text-rendering: optimizeSpeed;
        width: 100%
    }

    h3 {
        font-size: 1.25em
    }

    @media (max-width:549px) {
        h3 {
            font-size: 1em
        }
    }

    p {
        margin-top: 0
    }

    .is-small {
        font-size: .8em
    }

    .nav>li>a {
        font-size: .8em
    }

    .nav-size-medium>li>a {
        font-size: .9em
    }

    .nav-spacing-medium>li {
        margin: 0 9px
    }

    .container:after,
    .row:after {
        clear: both;
        content: "";
        display: table
    }

    @media (min-width:850px) {
        .show-for-medium {
            display: none !important
        }
    }

    @media (max-width:849px) {
        .hide-for-medium {
            display: none !important
        }
    }

    .full-width {
        display: block;
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important
    }

    .relative {
        position: relative !important
    }

    .fixed {
        position: fixed !important;
        z-index: 12
    }

    .bottom,
    .fill {
        bottom: 0
    }

    .fill {
        height: 100%;
        left: 0;
        margin: 0 !important;
        padding: 0 !important;
        position: absolute;
        right: 0;
        top: 0
    }

    .bg-fill {
        background-position: 50% 50%;
        background-repeat: no-repeat !important;
        background-size: cover !important
    }

    .circle {
        border-radius: 999px !important;
        -o-object-fit: cover;
        object-fit: cover
    }

    .z-1 {
        z-index: 21
    }

    .no-scrollbar {
        -ms-overflow-style: -ms-autohiding-scrollbar;
        scrollbar-width: none
    }

    .no-scrollbar::-webkit-scrollbar {
        height: 0 !important;
        width: 0 !important
    }

    .screen-reader-text {
        clip: rect(1px, 1px, 1px, 1px);
        height: 1px;
        overflow: hidden;
        position: absolute !important;
        width: 1px
    }

    :root {
        --flatsome-scroll-padding-top: calc(var(--flatsome--header--sticky-height, 0px) + var(--wp-admin--admin-bar--height, 0px))
    }

    html {
        overflow-x: hidden;
        scroll-padding-top: var(--flatsome-scroll-padding-top)
    }

    @supports (overflow:clip) {
        body {
            overflow-x: clip
        }
    }

    #main,
    #wrapper {
        background-color: #fff;
        position: relative
    }

    .header,
    .header-wrapper {
        background-position: 50% 0;
        background-size: cover;
        position: relative;
        width: 100%;
        z-index: 1001
    }

    .header-bg-color {
        background-color: hsla(0, 0%, 100%, .9)
    }

    .header-bg-color,
    .header-bg-image {
        background-position: 50% 0
    }

    .header-main {
        position: relative;
        z-index: 10
    }

    .top-divider {
        border-top: 1px solid;
        margin-bottom: -1px;
        opacity: .1
    }

    html {
        background-color: #5b5b5b
    }

    .back-to-top {
        bottom: 20px;
        margin: 0;
        opacity: 0;
        right: 20px;
        transform: translateY(30%)
    }

    .logo {
        line-height: 1;
        margin: 0
    }

    .logo a {
        color: var(--fs-color-primary);
        display: block;
        font-size: 32px;
        font-weight: bolder;
        margin: 0;
        text-decoration: none;
        text-transform: uppercase
    }

    .logo img {
        display: block;
        width: auto
    }

    .header-logo-dark {
        display: none !important
    }

    .logo-left .logo {
        margin-left: 0;
        margin-right: 30px
    }

    @media screen and (max-width:849px) {
        .header-inner .nav {
            flex-wrap: nowrap
        }

        .medium-logo-center .flex-left {
            flex: 1 1 0;
            order: 1
        }

        .medium-logo-center .logo {
            margin: 0 15px;
            order: 2;
            text-align: center
        }

        .medium-logo-center .logo img {
            margin: 0 auto
        }

        .medium-logo-center .flex-right {
            flex: 1 1 0;
            order: 3
        }
    }

    .icon-menu:before {
        content: ""
    }

    .icon-angle-up:before {
        content: ""
    }

    .bg {
        opacity: 0
    }

    .bg-loaded {
        opacity: 1
    }

    :root {
        --primary-color: #ed1c24;
        --fs-color-primary: #ed1c24;
        --fs-color-secondary: #3d3d3d;
        --fs-color-success: #7a9c59;
        --fs-color-alert: #b20000;
        --fs-experimental-link-color: #334862;
        --fs-experimental-link-color-hover: #111
    }

    .header-main {
        height: 90px
    }

    #logo img {
        max-height: 90px
    }

    #logo {
        width: 152px
    }

    @media (max-width:549px) {
        .header-main {
            height: 70px
        }

        #logo img {
            max-height: 70px
        }
    }

    body {
        font-family: Lato, sans-serif
    }

    body {
        font-weight: 400;
        font-style: normal
    }

    .nav>li>a {
        font-family: Lato, sans-serif
    }

    .nav>li>a {
        font-weight: 700;
        font-style: normal
    }

    h3 {
        font-family: Lato, sans-serif
    }

    h3 {
        font-weight: 700;
        font-style: normal
    }

    #section_1972770567 {
        padding-top: 30px;
        padding-bottom: 30px
    }

    :root {
        --wp--preset--aspect-ratio--square: 1;
        --wp--preset--aspect-ratio--4-3: 4/3;
        --wp--preset--aspect-ratio--3-4: 3/4;
        --wp--preset--aspect-ratio--3-2: 3/2;
        --wp--preset--aspect-ratio--2-3: 2/3;
        --wp--preset--aspect-ratio--16-9: 16/9;
        --wp--preset--aspect-ratio--9-16: 9/16;
        --wp--preset--color--black: #000;
        --wp--preset--color--cyan-bluish-gray: #abb8c3;
        --wp--preset--color--white: #fff;
        --wp--preset--color--pale-pink: #f78da7;
        --wp--preset--color--vivid-red: #cf2e2e;
        --wp--preset--color--luminous-vivid-orange: #ff6900;
        --wp--preset--color--luminous-vivid-amber: #fcb900;
        --wp--preset--color--light-green-cyan: #7bdcb5;
        --wp--preset--color--vivid-green-cyan: #00d084;
        --wp--preset--color--pale-cyan-blue: #8ed1fc;
        --wp--preset--color--vivid-cyan-blue: #0693e3;
        --wp--preset--color--vivid-purple: #9b51e0;
        --wp--preset--color--primary: #ed1c24;
        --wp--preset--color--secondary: #3d3d3d;
        --wp--preset--color--success: #7a9c59;
        --wp--preset--color--alert: #b20000;
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, #9b51e0 100%);
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, #7adcb4 0%, #00d082 100%);
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, #cf2e2e 100%);
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, #eee 0%, #a9b8c3 100%);
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, #4aeadc 0%, #9778d1 20%, #cf2aba 40%, #ee2c82 60%, #fb6962 80%, #fef84c 100%);
        --wp--preset--gradient--blush-light-purple: linear-gradient(135deg, #ffceec 0%, #9896f0 100%);
        --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, #fecda5 0%, #fe2d2d 50%, #6b003e 100%);
        --wp--preset--gradient--luminous-dusk: linear-gradient(135deg, #ffcb70 0%, #c751c0 50%, #4158d0 100%);
        --wp--preset--gradient--pale-ocean: linear-gradient(135deg, #fff5cb 0%, #b6e3d4 50%, #33a7b5 100%);
        --wp--preset--gradient--electric-grass: linear-gradient(135deg, #caf880 0%, #71ce7e 100%);
        --wp--preset--gradient--midnight: linear-gradient(135deg, #020381 0%, #2874fc 100%);
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
        --wp--preset--spacing--20: .44rem;
        --wp--preset--spacing--30: .67rem;
        --wp--preset--spacing--40: 1rem;
        --wp--preset--spacing--50: 1.5rem;
        --wp--preset--spacing--60: 2.25rem;
        --wp--preset--spacing--70: 3.38rem;
        --wp--preset--spacing--80: 5.06rem;
        --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, .2);
        --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, .4);
        --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, .2);
        --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);
        --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1)
    }

    body {
        padding-top: 0;
        padding-right: 0;
        padding-bottom: 0;
        padding-left: 0
    }
    </style>
    <link rel="preload" data-asynced="1" data-optimized="2" as="style" onload="this.onload=null;this.rel='stylesheet'"
        href="https://carllymotors.com/wp-content/litespeed/ucss/939328f31d69bb3b3934526366327132.css?ver=4d55a" />
    <script data-optimized="1" type="litespeed/javascript"
        data-src="https://carllymotors.com/wp-content/plugins/litespeed-cache/assets/js/css_async.min.js"></script>
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link rel="pingback" href="https://carllymotors.com/xmlrpc.php" />
    <script type="litespeed/javascript">
        (function(html){html.className=html.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <style>
    img:is([sizes="auto"i], [sizes^="auto,"i]) {
        contain-intrinsic-size: 3000px 1500px
    }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Privacy Policy - Carlly Motors</title>
    <link rel="canonical" href="https://carllymotors.com/privacy-policy/" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Privacy Policy - Carlly Motors" />
    <meta property="og:url" content="https://carllymotors.com/privacy-policy/" />
    <meta property="og:site_name" content="Carlly Motors" />
    <meta property="article:modified_time" content="2024-09-11T14:42:34+00:00" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:label1" content="Est. reading time" />
    <meta name="twitter:data1" content="2 minutes" />
    <script type="application/ld+json" class="yoast-schema-graph">
    {
        "@context": "https://schema.org",
        "@graph": [{
            "@type": "WebPage",
            "@id": "https://carllymotors.com/privacy-policy/",
            "url": "https://carllymotors.com/privacy-policy/",
            "name": "Privacy Policy - Carlly Motors",
            "isPartOf": {
                "@id": "https://carllymotors.com/#website"
            },
            "datePublished": "2024-04-17T15:52:24+00:00",
            "dateModified": "2024-09-11T14:42:34+00:00",
            "breadcrumb": {
                "@id": "https://carllymotors.com/privacy-policy/#breadcrumb"
            },
            "inLanguage": "en-US",
            "potentialAction": [{
                "@type": "ReadAction",
                "target": ["https://carllymotors.com/privacy-policy/"]
            }]
        }, {
            "@type": "BreadcrumbList",
            "@id": "https://carllymotors.com/privacy-policy/#breadcrumb",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "https://carllymotors.com/"
            }, {
                "@type": "ListItem",
                "position": 2,
                "name": "Privacy Policy"
            }]
        }, {
            "@type": "WebSite",
            "@id": "https://carllymotors.com/#website",
            "url": "https://carllymotors.com/",
            "name": "Carlly Motors",
            "description": "",
            "publisher": {
                "@id": "https://carllymotors.com/#organization"
            },
            "potentialAction": [{
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "https://carllymotors.com/?s={search_term_string}"
                },
                "query-input": {
                    "@type": "PropertyValueSpecification",
                    "valueRequired": true,
                    "valueName": "search_term_string"
                }
            }],
            "inLanguage": "en-US"
        }, {
            "@type": "Organization",
            "@id": "https://carllymotors.com/#organization",
            "name": "Carlly Motors",
            "url": "https://carllymotors.com/",
            "logo": {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "https://carllymotors.com/#/schema/logo/image/",
                "url": "https://carllymotors.com/wp-content/uploads/2024/04/carllymotorslogo.png",
                "contentUrl": "https://carllymotors.com/wp-content/uploads/2024/04/carllymotorslogo.png",
                "width": 2322,
                "height": 596,
                "caption": "Carlly Motors"
            },
            "image": {
                "@id": "https://carllymotors.com/#/schema/logo/image/"
            }
        }]
    }
    </script>
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/flatsome.js?ver=a0a7aee297766598a20e' />
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/chunk.slider.js?ver=3.18.7' />
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/chunk.popups.js?ver=3.18.7' />
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/chunk.tooltips.js?ver=3.18.7' />
    <link rel="alternate" type="application/rss+xml" title="Carlly Motors &raquo; Feed"
        href="https://carllymotors.com/feed/" />
    <link rel="alternate" type="application/rss+xml" title="Carlly Motors &raquo; Comments Feed"
        href="https://carllymotors.com/comments/feed/" />
    <link rel="alternate" type="application/rss+xml" title="Carlly Motors &raquo; Privacy Policy Comments Feed"
        href="https://carllymotors.com/privacy-policy/feed/" />
    <style id='flatsome-main-inline-css' type='text/css'>
    @font-face {
        font-family: "fl-icons";
        font-display: block;
        src: url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.eot?v=3.18.7);
        src:
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.eot#iefix?v=3.18.7) format("embedded-opentype"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.woff2?v=3.18.7) format("woff2"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.ttf?v=3.18.7) format("truetype"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.woff?v=3.18.7) format("woff"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.svg?v=3.18.7#fl-icons) format("svg");
    }
    </style>
    <script type="litespeed/javascript" data-src="https://carllymotors.com/wp-includes/js/jquery/jquery.min.js"
        id="jquery-core-js"></script>
    <link rel="https://api.w.org/" href="https://carllymotors.com/wp-json/" />
    <link rel="alternate" title="JSON" type="application/json" href="https://carllymotors.com/wp-json/wp/v2/pages/3" />
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://carllymotors.com/xmlrpc.php?rsd" />
    <meta name="generator" content="WordPress 6.7.2" />
    <link rel='shortlink' href='https://carllymotors.com/?p=3' />
    <link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed"
        href="https://carllymotors.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fcarllymotors.com%2Fprivacy-policy%2F" />
    <link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed"
        href="https://carllymotors.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fcarllymotors.com%2Fprivacy-policy%2F&#038;format=xml" />
    <style>
    .bg {
        opacity: 0;
        transition: opacity 1s;
        -webkit-transition: opacity 1s;
    }

    .bg-loaded {
        opacity: 1;
    }
    </style>
    <link rel="icon" href="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-32x32.png"
        sizes="32x32" />
    <link rel="icon" href="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-192x192.png"
        sizes="192x192" />
    <link rel="apple-touch-icon"
        href="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-180x180.png" />
    <meta name="msapplication-TileImage"
        content="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-270x270.png" />
    <style id="custom-css" type="text/css">
    :root {
        --primary-color: #ed1c24;
        --fs-color-primary: #ed1c24;
        --fs-color-secondary: #3d3d3d;
        --fs-color-success: #7a9c59;
        --fs-color-alert: #b20000;
        --fs-experimental-link-color: #334862;
        --fs-experimental-link-color-hover: #111;
    }

    .tooltipster-base {
        --tooltip-color: #fff;
        --tooltip-bg-color: #000;
    }

    .off-canvas-right .mfp-content,
    .off-canvas-left .mfp-content {
        --drawer-width: 300px;
    }

    .header-main {
        height: 90px
    }

    #logo img {
        max-height: 90px
    }

    #logo {
        width: 152px;
    }

    .header-top {
        min-height: 30px
    }

    .transparent .header-main {
        height: 90px
    }

    .transparent #logo img {
        max-height: 90px
    }

    .has-transparent+.page-title:first-of-type,
    .has-transparent+#main>.page-title,
    .has-transparent+#main>div>.page-title,
    .has-transparent+#main .page-header-wrapper:first-of-type .page-title {
        padding-top: 90px;
    }

    .header.show-on-scroll,
    .stuck .header-main {
        height: 70px !important
    }

    .stuck #logo img {
        max-height: 70px !important
    }

    .header-bottom {
        background-color: #f1f1f1
    }

    @media (max-width: 549px) {
        .header-main {
            height: 70px
        }

        #logo img {
            max-height: 70px
        }
    }

    .main-menu-overlay {
        background-color: #dd3333
    }

    body {
        font-family: Lato, sans-serif;
    }

    body {
        font-weight: 400;
        font-style: normal;
    }

    .nav>li>a {
        font-family: Lato, sans-serif;
    }

    .mobile-sidebar-levels-2 .nav>li>ul>li>a {
        font-family: Lato, sans-serif;
    }

    .nav>li>a,
    .mobile-sidebar-levels-2 .nav>li>ul>li>a {
        font-weight: 700;
        font-style: normal;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .heading-font,
    .off-canvas-center .nav-sidebar.nav-vertical>li>a {
        font-family: Lato, sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .heading-font,
    .banner h1,
    .banner h2 {
        font-weight: 700;
        font-style: normal;
    }

    .alt-font {
        font-family: "Dancing Script", sans-serif;
    }

    .alt-font {
        font-weight: 400 !important;
        font-style: normal !important;
    }

    .nav-vertical-fly-out>li+li {
        border-top-width: 1px;
        border-top-style: solid;
    }

    .label-new.menu-item>a:after {
        content: "New";
    }

    .label-hot.menu-item>a:after {
        content: "Hot";
    }

    .label-sale.menu-item>a:after {
        content: "Sale";
    }

    .label-popular.menu-item>a:after {
        content: "Popular";
    }
    </style>
    <style id="kirki-inline-styles">
    /* latin-ext */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6uyw4BMUTPHjxAwXjeu.woff2) format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6uyw4BMUTPHjx4wXg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6u9w4BMUTPHh6UVSwaPGR_p.woff2) format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6u9w4BMUTPHh6UVSwiPGQ.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    /* vietnamese */
    @font-face {
        font-family: 'Dancing Script';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/dancing-script/If2cXTr6YS-zF4S-kcSWSVi_sxjsohD9F50Ruu7BMSo3Rep8ltA.woff2) format('woff2');
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Dancing Script';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/dancing-script/If2cXTr6YS-zF4S-kcSWSVi_sxjsohD9F50Ruu7BMSo3ROp8ltA.woff2) format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Dancing Script';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/dancing-script/If2cXTr6YS-zF4S-kcSWSVi_sxjsohD9F50Ruu7BMSo3Sup8.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    </style>
</head>

<body
    class="privacy-policy page-template page-template-page-blank page-template-page-blank-php page page-id-3 lightbox nav-dropdown-has-arrow nav-dropdown-has-shadow nav-dropdown-has-border">
    <a class="skip-link screen-reader-text" href="#main">Skip to content</a>
    <div id="wrapper">
        
        <main id="main" class="">
            <div id="content" role="main" class="content-area">
                <section class="section" id="section_293291896">
                    <div class="bg section-bg fill bg-fill  bg-loaded"></div>
                    <div class="section-content relative">
                        <div class="row" id="row-1791097778">
                            <div id="col-1564552859" class="col small-12 large-12">
                                <div class="col-inner">
                                    <p><strong>Privacy Policy for Carlly Motors</strong></p>
                                    <p><strong>Effective Date: 11/Sep/2024</strong></p>
                                    <p>At Carlly Motors, we prioritize your privacy and are committed to safeguarding
                                        the personal information you share with us. This Privacy Policy outlines how we
                                        collect, use, and protect your information when you use our platform,
                                        carllymotors.com, and related services.</p>
                                    <h3>1. <strong>Information We Collect</strong></h3>
                                    <p>We collect various types of information to provide and improve our services:</p>
                                    <ul>
                                        <li><strong>Personal Information:</strong> When you register on Carlly Motors,
                                            we may collect personal details such as your name, email address, phone
                                            number, and location.</li>
                                        <li><strong>Transaction Data:</strong> Information related to the purchase,
                                            sale, or auction of cars and car parts, including vehicle details, payment
                                            information, and transaction history.</li>
                                        <li><strong>Device and Usage Data:</strong> Information about your device,
                                            browsing actions, and patterns when using our platform, such as IP address,
                                            browser type, and pages visited.</li>
                                    </ul>
                                    <h3>2. <strong>How We Use Your Information</strong></h3>
                                    <p>We use your data to:</p>
                                    <ul>
                                        <li>Facilitate transactions between customers and vendors.</li>
                                        <li>Process payments securely.</li>
                                        <li>Communicate updates, promotions, or offers.</li>
                                        <li>Improve our platform&#8217;s functionality and user experience.</li>
                                        <li>Comply with legal requirements.</li>
                                    </ul>
                                    <h3>3. <strong>Sharing of Information</strong></h3>
                                    <p>We may share your personal information in the following scenarios:</p>
                                    <ul>
                                        <li><strong>With Vendors and Customers:</strong> To facilitate communication and
                                            transactions between users of Carlly Motors.</li>
                                        <li><strong>Service Providers:</strong> We may share information with
                                            third-party providers who assist us in operating our platform and services,
                                            such as payment processors.</li>
                                        <li><strong>Legal Compliance:</strong> If required by law, we may disclose
                                            information to regulatory authorities.</li>
                                    </ul>
                                    <h3>4. <strong>Data Security</strong></h3>
                                    <p>We implement robust security measures to protect your personal data. However, no
                                        method of online transmission is 100% secure, and we cannot guarantee absolute
                                        protection.</p>
                                    <h3>5. <strong>Your Rights</strong></h3>
                                    <ul>
                                        <li><strong>Access and Correction:</strong> You can review and update your
                                            personal information in your account settings.</li>
                                        <li><strong>Deletion:</strong> You may request the deletion of your account and
                                            personal data by contacting us at <a rel="noopener"><span
                                                    class="__cf_email__"
                                                    data-cfemail="71181f171e311210031d1d081c1e051e03025f121e1c">[email&#160;protected]</span></a>.
                                        </li>
                                        <li><strong>Opt-Out:</strong> You can opt out of promotional communications by
                                            following the unsubscribe instructions in emails.</li>
                                    </ul>
                                    <h3>6. <strong>Cookies and Tracking Technologies</strong></h3>
                                    <p>Carlly Motors uses cookies to enhance your experience and analyze platform
                                        performance. You can manage your cookie preferences in your browser settings.
                                    </p>
                                    <h3>7. <strong>Third-Party Links</strong></h3>
                                    <p>Our platform may contain links to third-party websites. We are not responsible
                                        for the privacy practices of these external sites.</p>
                                    <h3>8. <strong>Children’s Privacy</strong></h3>
                                    <p>Our services are not directed at individuals under the age of 18. We do not
                                        knowingly collect information from children.</p>
                                    <h3>9. <strong>Changes to This Policy</strong></h3>
                                    <p>We reserve the right to modify this Privacy Policy at any time. Any changes will
                                        be posted on this page with the updated effective date.</p>
                                    <h3>10. <strong>Contact Us</strong></h3>
                                    <p>If you have any questions about this Privacy Policy, please contact us at:</p>
                                    <ul>
                                        <li>Email: <a rel="noopener"><span class="__cf_email__"
                                                    data-cfemail="d5bcbbb3ba95b6b4a7b9b9acb8baa1baa7a6fbb6bab8">[email&#160;protected]</span></a>
                                        </li>
                                        <li>Website: carllymotors.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                    #section_293291896 {
                        padding-top: 30px;
                        padding-bottom: 30px;
                    }
                    </style>
                </section>
            </div>
        </main>
        
    </div>
    <div id="main-menu" class="mobile-sidebar no-scrollbar mfp-hide">
        <div class="sidebar-menu no-scrollbar ">
            <ul class="nav nav-sidebar nav-vertical nav-uppercase" data-tab="1">
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-20"><a
                        href="https://carllymotors.com/">Home</a></li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-21"><a
                        href="#Features">Features</a></li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-23"><a
                        href="#Download_App">Download App</a></li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-101"><a
                        href="https://carllymotors.com/about-us/">About US</a></li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-100"><a
                        href="https://carllymotors.com/contact-us/">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <div class="joinchat joinchat--right"
        data-settings='{"telephone":"971566350025","mobile_only":false,"button_delay":3,"whatsapp_web":false,"qr":false,"message_views":2,"message_delay":-10,"message_badge":false,"message_send":"Hi *Carlly Motors*! I need more info about Privacy Policy https://carllymotors.com/privacy-policy","message_hash":"d9a13fe0"}'>
        <div class="joinchat__button">
            <div class="joinchat__button__open"></div>
            <div class="joinchat__button__sendtext">Open chat</div>
            <svg class="joinchat__button__send" width="60" height="60" viewbox="0 0 400 400" stroke-linecap="round"
                stroke-width="33">
                <path class="joinchat_svg__plain"
                    d="M168.83 200.504H79.218L33.04 44.284a1 1 0 0 1 1.386-1.188L365.083 199.04a1 1 0 0 1 .003 1.808L34.432 357.903a1 1 0 0 1-1.388-1.187l29.42-99.427" />
                <path class="joinchat_svg__chat"
                    d="M318.087 318.087c-52.982 52.982-132.708 62.922-195.725 29.82l-80.449 10.18 10.358-80.112C18.956 214.905 28.836 134.99 81.913 81.913c65.218-65.217 170.956-65.217 236.174 0 42.661 42.661 57.416 102.661 44.265 157.316" />
            </svg>
        </div>
        <div class="joinchat__box">
            <div class="joinchat__header">
                <a class="joinchat__powered"
                    href="https://join.chat/en/powered/?site=Carlly%20Motors&#038;url=https%3A%2F%2Fcarllymotors.com%2Fprivacy-policy"
                    rel="nofollow noopener" target="_blank">
                    Powered by <svg width="81" height="18" viewbox="0 0 1424 318">
                        <title>Joinchat</title>
                        <path
                            d="m171 7 6 2 3 3v5l-1 8a947 947 0 0 0-2 56v53l1 24v31c0 22-6 43-18 63-11 19-27 35-48 48s-44 18-69 18c-14 0-24-3-32-8-7-6-11-13-11-23a26 26 0 0 1 26-27c7 0 13 2 19 6l12 12 1 1a97 97 0 0 0 10 13c4 4 7 6 10 6 4 0 7-2 10-6l6-23v-1c2-12 3-28 3-48V76l-1-3-3-1h-1l-11-2c-2-1-3-3-3-7s1-6 3-7a434 434 0 0 0 90-49zm1205 43c4 0 6 1 6 3l3 36a1888 1888 0 0 0 34 0h1l3 2 1 8-1 8-3 1h-35v62c0 14 2 23 5 28 3 6 9 8 16 8l5-1 3-1c2 0 3 1 5 3s3 4 2 6c-4 10-11 19-22 27-10 8-22 12-36 12-16 0-28-5-37-15l-8-13v1h-1c-17 17-33 26-47 26-18 0-31-13-39-39-5 12-12 22-21 29s-19 10-31 10c-11 0-21-4-29-13-7-8-11-18-11-30 0-10 2-17 5-23s9-11 17-15c13-7 35-14 67-21h1v-11c0-11-2-19-5-26-4-6-8-9-14-9-3 0-5 1-5 4v1l-2 15c-2 11-6 19-11 24-6 6-14 8-23 8-5 0-9-1-13-4-3-3-5-8-5-13 0-11 9-22 26-33s38-17 60-17c41 0 62 15 62 46v58l1 11 2 8 2 3h4l5-3 1-1-1-13v-88l-3-2-12-1c-1 0-2-3-2-7s1-6 2-6c16-4 29-9 40-15 10-6 20-15 31-25 1-2 4-3 7-3zM290 88c28 0 50 7 67 22 17 14 25 34 25 58 0 26-9 46-27 61s-42 22-71 22c-28 0-50-7-67-22a73 73 0 0 1-25-58c0-26 9-46 27-61s42-22 71-22zm588 0c19 0 34 4 45 12 11 9 17 18 17 29 0 6-3 11-7 15s-10 6-17 6c-13 0-24-8-33-25-5-11-10-18-13-21s-6-5-9-5c-8 0-11 6-11 17a128 128 0 0 0 32 81c8 8 16 12 25 12 8 0 16-3 24-10 1-1 3 0 6 2 2 2 3 3 3 5-5 12-15 23-29 32s-30 13-48 13c-24 0-43-7-58-22a78 78 0 0 1-22-58c0-25 9-45 27-60s41-23 68-23zm-402-3 5 2 3 3-1 10a785 785 0 0 0-2 53v76c1 3 2 4 4 4l11 3 11-3c3 0 4-1 4-4v-82l-1-2-3-2-11-1-2-6c0-4 1-6 2-6a364 364 0 0 0 77-44l5 2 3 3v12a393 393 0 0 0-1 21c5-10 12-18 22-25 9-8 21-11 34-11 16 0 29 5 38 14 10 9 14 22 14 39v88c0 3 2 4 4 4l11 3c1 0 2 2 2 6 0 5-1 7-2 7h-1a932 932 0 0 1-49-2 462 462 0 0 0-48 2c-2 0-3-2-3-7 0-3 1-6 3-6l8-3 3-1 1-3v-62c0-14-2-24-6-29-4-6-12-9-22-9l-7 1v99l1 3 3 1 8 3h1l2 6c0 5-1 7-3 7a783 783 0 0 1-47-2 512 512 0 0 0-51 2h-1a895 895 0 0 1-49-2 500 500 0 0 0-50 2c-1 0-2-2-2-7 0-4 1-6 2-6l11-3c2 0 3-1 4-4v-82l-1-3-3-1-11-2c-1 0-2-2-2-6l2-6a380 380 0 0 0 80-44zm539-75 5 2 3 3-1 9a758 758 0 0 0-2 55v42h1c5-9 12-16 21-22 9-7 20-10 32-10 16 0 29 5 38 14 10 9 14 22 14 39v88c0 2 2 3 4 4l11 2c1 0 2 2 2 7 0 4-1 6-2 6h-1a937 937 0 0 1-49-2 466 466 0 0 0-48 2c-2 0-3-2-3-6s1-7 3-7l8-2 3-2 1-3v-61c0-14-2-24-6-29-4-6-12-9-22-9l-7 1v99l1 2 3 2 8 2h1c1 1 2 3 2 7s-1 6-3 6a788 788 0 0 1-47-2 517 517 0 0 0-51 2c-1 0-2-2-2-6 0-5 1-7 2-7l11-2c3-1 4-2 4-5V71l-1-3-3-1-11-2c-1 0-2-2-2-6l2-6a387 387 0 0 0 81-43zm-743 90c-8 0-12 7-12 20a266 266 0 0 0 33 116c3 3 6 4 9 4 8 0 12-6 12-20 0-17-4-38-11-65-8-27-15-44-22-50-3-4-6-5-9-5zm939 65c-6 0-9 4-9 13 0 8 2 16 7 22 5 7 10 10 15 10l6-2v-22c0-6-2-11-7-15-4-4-8-6-12-6zM451 0c10 0 18 3 25 10s10 16 10 26a35 35 0 0 1-35 36c-11 0-19-4-26-10-7-7-10-16-10-26s3-19 10-26 15-10 26-10zm297 249c9 0 16-3 22-8 6-6 9-12 9-20s-3-15-9-21-13-8-22-8-16 3-22 8-9 12-9 21 3 14 9 20 13 8 22 8z" />
                    </svg>
                </a>
                <div class="joinchat__close" title="Close"></div>
            </div>
            <div class="joinchat__box__scroll">
                <div class="joinchat__box__content">
                    <div class="joinchat__message">Hello 👋<br>Can we help you?</div>
                </div>
            </div>
        </div>
        <svg style="width:0;height:0;position:absolute">
            <defs>
                <clipPath id="joinchat__peak_l">
                    <path
                        d="M17 25V0C17 12.877 6.082 14.9 1.031 15.91c-1.559.31-1.179 2.272.004 2.272C9.609 18.182 17 18.088 17 25z" />
                </clipPath>
                <clipPath id="joinchat__peak_r">
                    <path
                        d="M0 25.68V0c0 13.23 10.92 15.3 15.97 16.34 1.56.32 1.18 2.34 0 2.34-8.58 0-15.97-.1-15.97 7Z" />
                </clipPath>
            </defs>
        </svg>
    </div>
    <style id='global-styles-inline-css' type='text/css'>
    :root {
        --wp--preset--aspect-ratio--square: 1;
        --wp--preset--aspect-ratio--4-3: 4/3;
        --wp--preset--aspect-ratio--3-4: 3/4;
        --wp--preset--aspect-ratio--3-2: 3/2;
        --wp--preset--aspect-ratio--2-3: 2/3;
        --wp--preset--aspect-ratio--16-9: 16/9;
        --wp--preset--aspect-ratio--9-16: 9/16;
        --wp--preset--color--black: #000000;
        --wp--preset--color--cyan-bluish-gray: #abb8c3;
        --wp--preset--color--white: #ffffff;
        --wp--preset--color--pale-pink: #f78da7;
        --wp--preset--color--vivid-red: #cf2e2e;
        --wp--preset--color--luminous-vivid-orange: #ff6900;
        --wp--preset--color--luminous-vivid-amber: #fcb900;
        --wp--preset--color--light-green-cyan: #7bdcb5;
        --wp--preset--color--vivid-green-cyan: #00d084;
        --wp--preset--color--pale-cyan-blue: #8ed1fc;
        --wp--preset--color--vivid-cyan-blue: #0693e3;
        --wp--preset--color--vivid-purple: #9b51e0;
        --wp--preset--color--primary: #ed1c24;
        --wp--preset--color--secondary: #3d3d3d;
        --wp--preset--color--success: #7a9c59;
        --wp--preset--color--alert: #b20000;
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, rgb(155, 81, 224) 100%);
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, rgb(207, 46, 46) 100%);
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
        --wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
        --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
        --wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
        --wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
        --wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
        --wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
        --wp--preset--spacing--20: 0.44rem;
        --wp--preset--spacing--30: 0.67rem;
        --wp--preset--spacing--40: 1rem;
        --wp--preset--spacing--50: 1.5rem;
        --wp--preset--spacing--60: 2.25rem;
        --wp--preset--spacing--70: 3.38rem;
        --wp--preset--spacing--80: 5.06rem;
        --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
        --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);
        --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
    }

    :where(body) {
        margin: 0;
    }

    .wp-site-blocks>.alignleft {
        float: left;
        margin-right: 2em;
    }

    .wp-site-blocks>.alignright {
        float: right;
        margin-left: 2em;
    }

    .wp-site-blocks>.aligncenter {
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    :where(.is-layout-flex) {
        gap: 0.5em;
    }

    :where(.is-layout-grid) {
        gap: 0.5em;
    }

    .is-layout-flow>.alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
    }

    .is-layout-flow>.alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
    }

    .is-layout-flow>.aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .is-layout-constrained>.alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
    }

    .is-layout-constrained>.alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
    }

    .is-layout-constrained>.aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .is-layout-constrained> :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    body .is-layout-flex {
        display: flex;
    }

    .is-layout-flex {
        flex-wrap: wrap;
        align-items: center;
    }

    .is-layout-flex> :is(*, div) {
        margin: 0;
    }

    body .is-layout-grid {
        display: grid;
    }

    .is-layout-grid> :is(*, div) {
        margin: 0;
    }

    body {
        padding-top: 0px;
        padding-right: 0px;
        padding-bottom: 0px;
        padding-left: 0px;
    }

    a:where(:not(.wp-element-button)) {
        text-decoration: none;
    }

    :root :where(.wp-element-button, .wp-block-button__link) {
        background-color: #32373c;
        border-width: 0;
        color: #fff;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        padding: calc(0.667em + 2px) calc(1.333em + 2px);
        text-decoration: none;
    }

    .has-black-color {
        color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-color {
        color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-color {
        color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-color {
        color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-color {
        color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-color {
        color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-color {
        color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-color {
        color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-color {
        color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-color {
        color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-color {
        color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-color {
        color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-primary-color {
        color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-color {
        color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-color {
        color: var(--wp--preset--color--success) !important;
    }

    .has-alert-color {
        color: var(--wp--preset--color--alert) !important;
    }

    .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-background-color {
        background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-background-color {
        background-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-background-color {
        background-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-background-color {
        background-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-background-color {
        background-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-background-color {
        background-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-background-color {
        background-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-background-color {
        background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-background-color {
        background-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-primary-background-color {
        background-color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-background-color {
        background-color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-background-color {
        background-color: var(--wp--preset--color--success) !important;
    }

    .has-alert-background-color {
        background-color: var(--wp--preset--color--alert) !important;
    }

    .has-black-border-color {
        border-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-border-color {
        border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-border-color {
        border-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-border-color {
        border-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-border-color {
        border-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-border-color {
        border-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-border-color {
        border-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-border-color {
        border-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-border-color {
        border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-border-color {
        border-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-primary-border-color {
        border-color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-border-color {
        border-color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-border-color {
        border-color: var(--wp--preset--color--success) !important;
    }

    .has-alert-border-color {
        border-color: var(--wp--preset--color--alert) !important;
    }

    .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
        background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
    }

    .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
        background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
    }

    .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-orange-to-vivid-red-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
    }

    .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
        background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
    }

    .has-cool-to-warm-spectrum-gradient-background {
        background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
    }

    .has-blush-light-purple-gradient-background {
        background: var(--wp--preset--gradient--blush-light-purple) !important;
    }

    .has-blush-bordeaux-gradient-background {
        background: var(--wp--preset--gradient--blush-bordeaux) !important;
    }

    .has-luminous-dusk-gradient-background {
        background: var(--wp--preset--gradient--luminous-dusk) !important;
    }

    .has-pale-ocean-gradient-background {
        background: var(--wp--preset--gradient--pale-ocean) !important;
    }

    .has-electric-grass-gradient-background {
        background: var(--wp--preset--gradient--electric-grass) !important;
    }

    .has-midnight-gradient-background {
        background: var(--wp--preset--gradient--midnight) !important;
    }

    .has-small-font-size {
        font-size: var(--wp--preset--font-size--small) !important;
    }

    .has-medium-font-size {
        font-size: var(--wp--preset--font-size--medium) !important;
    }

    .has-large-font-size {
        font-size: var(--wp--preset--font-size--large) !important;
    }

    .has-x-large-font-size {
        font-size: var(--wp--preset--font-size--x-large) !important;
    }
    </style>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script id="wp-i18n-js-after" type="litespeed/javascript">wp.i18n.setLocaleData({'text direction\u0004ltr':['ltr']})
    </script>
    <script id="contact-form-7-js-before" type="litespeed/javascript">
        var wpcf7={"api":{"root":"https:\/\/carllymotors.com\/wp-json\/","namespace":"contact-form-7\/v1"},"cached":1}
    </script>
    <script id="flatsome-js-js-extra" type="litespeed/javascript">
        var flatsomeVars={"theme":{"version":"3.18.7"},"ajaxurl":"https:\/\/carllymotors.com\/wp-admin\/admin-ajax.php","rtl":"","sticky_height":"70","stickyHeaderHeight":"0","scrollPaddingTop":"0","assets_url":"https:\/\/carllymotors.com\/wp-content\/themes\/flatsome\/assets\/","lightbox":{"close_markup":"<button title=\"%title%\" type=\"button\" class=\"mfp-close\"><svg xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"><\/line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"><\/line><\/svg><\/button>","close_btn_inside":!1},"user":{"can_edit_pages":!1},"i18n":{"mainMenu":"Main Menu","toggleButton":"Toggle"},"options":{"cookie_notice_version":"1","swatches_layout":!1,"swatches_disable_deselect":!1,"swatches_box_select_event":!1,"swatches_box_behavior_selected":!1,"swatches_box_update_urls":"1","swatches_box_reset":!1,"swatches_box_reset_limited":!1,"swatches_box_reset_extent":!1,"swatches_box_reset_time":300,"search_result_latency":"0"}}
    </script>
    <script data-no-optimize="1">
    ! function(t, e) {
        "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" ==
            typeof define && define.amd ? define(e) : (t = "undefined" != typeof globalThis ? globalThis : t || self)
            .LazyLoad = e()
    }(this, function() {
        "use strict";

        function e() {
            return (e = Object.assign || function(t) {
                for (var e = 1; e < arguments.length; e++) {
                    var n, a = arguments[e];
                    for (n in a) Object.prototype.hasOwnProperty.call(a, n) && (t[n] = a[n])
                }
                return t
            }).apply(this, arguments)
        }

        function i(t) {
            return e({}, it, t)
        }

        function o(t, e) {
            var n, a = "LazyLoad::Initialized",
                i = new t(e);
            try {
                n = new CustomEvent(a, {
                    detail: {
                        instance: i
                    }
                })
            } catch (t) {
                (n = document.createEvent("CustomEvent")).initCustomEvent(a, !1, !1, {
                    instance: i
                })
            }
            window.dispatchEvent(n)
        }

        function l(t, e) {
            return t.getAttribute(gt + e)
        }

        function c(t) {
            return l(t, bt)
        }

        function s(t, e) {
            return function(t, e, n) {
                e = gt + e;
                null !== n ? t.setAttribute(e, n) : t.removeAttribute(e)
            }(t, bt, e)
        }

        function r(t) {
            return s(t, null), 0
        }

        function u(t) {
            return null === c(t)
        }

        function d(t) {
            return c(t) === vt
        }

        function f(t, e, n, a) {
            t && (void 0 === a ? void 0 === n ? t(e) : t(e, n) : t(e, n, a))
        }

        function _(t, e) {
            nt ? t.classList.add(e) : t.className += (t.className ? " " : "") + e
        }

        function v(t, e) {
            nt ? t.classList.remove(e) : t.className = t.className.replace(new RegExp("(^|\\s+)" + e + "(\\s+|$)"),
                " ").replace(/^\s+/, "").replace(/\s+$/, "")
        }

        function g(t) {
            return t.llTempImage
        }

        function b(t, e) {
            !e || (e = e._observer) && e.unobserve(t)
        }

        function p(t, e) {
            t && (t.loadingCount += e)
        }

        function h(t, e) {
            t && (t.toLoadCount = e)
        }

        function n(t) {
            for (var e, n = [], a = 0; e = t.children[a]; a += 1) "SOURCE" === e.tagName && n.push(e);
            return n
        }

        function m(t, e) {
            (t = t.parentNode) && "PICTURE" === t.tagName && n(t).forEach(e)
        }

        function a(t, e) {
            n(t).forEach(e)
        }

        function E(t) {
            return !!t[st]
        }

        function I(t) {
            return t[st]
        }

        function y(t) {
            return delete t[st]
        }

        function A(e, t) {
            var n;
            E(e) || (n = {}, t.forEach(function(t) {
                n[t] = e.getAttribute(t)
            }), e[st] = n)
        }

        function k(a, t) {
            var i;
            E(a) && (i = I(a), t.forEach(function(t) {
                var e, n;
                e = a, (t = i[n = t]) ? e.setAttribute(n, t) : e.removeAttribute(n)
            }))
        }

        function L(t, e, n) {
            _(t, e.class_loading), s(t, ut), n && (p(n, 1), f(e.callback_loading, t, n))
        }

        function w(t, e, n) {
            n && t.setAttribute(e, n)
        }

        function x(t, e) {
            w(t, ct, l(t, e.data_sizes)), w(t, rt, l(t, e.data_srcset)), w(t, ot, l(t, e.data_src))
        }

        function O(t, e, n) {
            var a = l(t, e.data_bg_multi),
                i = l(t, e.data_bg_multi_hidpi);
            (a = at && i ? i : a) && (t.style.backgroundImage = a, n = n, _(t = t, (e = e).class_applied), s(t, ft),
                n && (e.unobserve_completed && b(t, e), f(e.callback_applied, t, n)))
        }

        function N(t, e) {
            !e || 0 < e.loadingCount || 0 < e.toLoadCount || f(t.callback_finish, e)
        }

        function C(t, e, n) {
            t.addEventListener(e, n), t.llEvLisnrs[e] = n
        }

        function M(t) {
            return !!t.llEvLisnrs
        }

        function z(t) {
            if (M(t)) {
                var e, n, a = t.llEvLisnrs;
                for (e in a) {
                    var i = a[e];
                    n = e, i = i, t.removeEventListener(n, i)
                }
                delete t.llEvLisnrs
            }
        }

        function R(t, e, n) {
            var a;
            delete t.llTempImage, p(n, -1), (a = n) && --a.toLoadCount, v(t, e.class_loading), e
                .unobserve_completed && b(t, n)
        }

        function T(o, r, c) {
            var l = g(o) || o;
            M(l) || function(t, e, n) {
                M(t) || (t.llEvLisnrs = {});
                var a = "VIDEO" === t.tagName ? "loadeddata" : "load";
                C(t, a, e), C(t, "error", n)
            }(l, function(t) {
                var e, n, a, i;
                n = r, a = c, i = d(e = o), R(e, n, a), _(e, n.class_loaded), s(e, dt), f(n.callback_loaded,
                    e, a), i || N(n, a), z(l)
            }, function(t) {
                var e, n, a, i;
                n = r, a = c, i = d(e = o), R(e, n, a), _(e, n.class_error), s(e, _t), f(n.callback_error,
                    e, a), i || N(n, a), z(l)
            })
        }

        function G(t, e, n) {
            var a, i, o, r, c;
            t.llTempImage = document.createElement("IMG"), T(t, e, n), E(c = t) || (c[st] = {
                backgroundImage: c.style.backgroundImage
            }), o = n, r = l(a = t, (i = e).data_bg), c = l(a, i.data_bg_hidpi), (r = at && c ? c : r) && (a
                .style.backgroundImage = 'url("'.concat(r, '")'), g(a).setAttribute(ot, r), L(a, i, o)), O(t, e,
                n)
        }

        function D(t, e, n) {
            var a;
            T(t, e, n), a = e, e = n, (t = It[(n = t).tagName]) && (t(n, a), L(n, a, e))
        }

        function V(t, e, n) {
            var a;
            a = t, (-1 < yt.indexOf(a.tagName) ? D : G)(t, e, n)
        }

        function F(t, e, n) {
            var a;
            t.setAttribute("loading", "lazy"), T(t, e, n), a = e, (e = It[(n = t).tagName]) && e(n, a), s(t, vt)
        }

        function j(t) {
            t.removeAttribute(ot), t.removeAttribute(rt), t.removeAttribute(ct)
        }

        function P(t) {
            m(t, function(t) {
                k(t, Et)
            }), k(t, Et)
        }

        function S(t) {
            var e;
            (e = At[t.tagName]) ? e(t): E(e = t) && (t = I(e), e.style.backgroundImage = t.backgroundImage)
        }

        function U(t, e) {
            var n;
            S(t), n = e, u(e = t) || d(e) || (v(e, n.class_entered), v(e, n.class_exited), v(e, n.class_applied), v(
                e, n.class_loading), v(e, n.class_loaded), v(e, n.class_error)), r(t), y(t)
        }

        function $(t, e, n, a) {
            var i;
            n.cancel_on_exit && (c(t) !== ut || "IMG" === t.tagName && (z(t), m(i = t, function(t) {
                j(t)
            }), j(i), P(t), v(t, n.class_loading), p(a, -1), r(t), f(n.callback_cancel, t, e, a)))
        }

        function q(t, e, n, a) {
            var i, o, r = (o = t, 0 <= pt.indexOf(c(o)));
            s(t, "entered"), _(t, n.class_entered), v(t, n.class_exited), i = t, o = a, n.unobserve_entered && b(i,
                o), f(n.callback_enter, t, e, a), r || V(t, n, a)
        }

        function H(t) {
            return t.use_native && "loading" in HTMLImageElement.prototype
        }

        function B(t, i, o) {
            t.forEach(function(t) {
                return (a = t).isIntersecting || 0 < a.intersectionRatio ? q(t.target, t, i, o) : (e = t
                    .target, n = t, a = i, t = o, void(u(e) || (_(e, a.class_exited), $(e, n, a, t), f(a
                        .callback_exit, e, n, t))));
                var e, n, a
            })
        }

        function J(e, n) {
            var t;
            et && !H(e) && (n._observer = new IntersectionObserver(function(t) {
                B(t, e, n)
            }, {
                root: (t = e).container === document ? null : t.container,
                rootMargin: t.thresholds || t.threshold + "px"
            }))
        }

        function K(t) {
            return Array.prototype.slice.call(t)
        }

        function Q(t) {
            return t.container.querySelectorAll(t.elements_selector)
        }

        function W(t) {
            return c(t) === _t
        }

        function X(t, e) {
            return e = t || Q(e), K(e).filter(u)
        }

        function Y(e, t) {
            var n;
            (n = Q(e), K(n).filter(W)).forEach(function(t) {
                v(t, e.class_error), r(t)
            }), t.update()
        }

        function t(t, e) {
            var n, a, t = i(t);
            this._settings = t, this.loadingCount = 0, J(t, this), n = t, a = this, Z && window.addEventListener(
                "online",
                function() {
                    Y(n, a)
                }), this.update(e)
        }
        var Z = "undefined" != typeof window,
            tt = Z && !("onscroll" in window) || "undefined" != typeof navigator && /(gle|ing|ro)bot|crawl|spider/i
            .test(navigator.userAgent),
            et = Z && "IntersectionObserver" in window,
            nt = Z && "classList" in document.createElement("p"),
            at = Z && 1 < window.devicePixelRatio,
            it = {
                elements_selector: ".lazy",
                container: tt || Z ? document : null,
                threshold: 300,
                thresholds: null,
                data_src: "src",
                data_srcset: "srcset",
                data_sizes: "sizes",
                data_bg: "bg",
                data_bg_hidpi: "bg-hidpi",
                data_bg_multi: "bg-multi",
                data_bg_multi_hidpi: "bg-multi-hidpi",
                data_poster: "poster",
                class_applied: "applied",
                class_loading: "litespeed-loading",
                class_loaded: "litespeed-loaded",
                class_error: "error",
                class_entered: "entered",
                class_exited: "exited",
                unobserve_completed: !0,
                unobserve_entered: !1,
                cancel_on_exit: !0,
                callback_enter: null,
                callback_exit: null,
                callback_applied: null,
                callback_loading: null,
                callback_loaded: null,
                callback_error: null,
                callback_finish: null,
                callback_cancel: null,
                use_native: !1
            },
            ot = "src",
            rt = "srcset",
            ct = "sizes",
            lt = "poster",
            st = "llOriginalAttrs",
            ut = "loading",
            dt = "loaded",
            ft = "applied",
            _t = "error",
            vt = "native",
            gt = "data-",
            bt = "ll-status",
            pt = [ut, dt, ft, _t],
            ht = [ot],
            mt = [ot, lt],
            Et = [ot, rt, ct],
            It = {
                IMG: function(t, e) {
                    m(t, function(t) {
                        A(t, Et), x(t, e)
                    }), A(t, Et), x(t, e)
                },
                IFRAME: function(t, e) {
                    A(t, ht), w(t, ot, l(t, e.data_src))
                },
                VIDEO: function(t, e) {
                    a(t, function(t) {
                        A(t, ht), w(t, ot, l(t, e.data_src))
                    }), A(t, mt), w(t, lt, l(t, e.data_poster)), w(t, ot, l(t, e.data_src)), t.load()
                }
            },
            yt = ["IMG", "IFRAME", "VIDEO"],
            At = {
                IMG: P,
                IFRAME: function(t) {
                    k(t, ht)
                },
                VIDEO: function(t) {
                    a(t, function(t) {
                        k(t, ht)
                    }), k(t, mt), t.load()
                }
            },
            kt = ["IMG", "IFRAME", "VIDEO"];
        return t.prototype = {
            update: function(t) {
                var e, n, a, i = this._settings,
                    o = X(t, i); {
                    if (h(this, o.length), !tt && et) return H(i) ? (e = i, n = this, o.forEach(function(
                    t) {
                        -1 !== kt.indexOf(t.tagName) && F(t, e, n)
                    }), void h(n, 0)) : (t = this._observer, i = o, t.disconnect(), a = t, void i
                        .forEach(function(t) {
                            a.observe(t)
                        }));
                    this.loadAll(o)
                }
            },
            destroy: function() {
                this._observer && this._observer.disconnect(), Q(this._settings).forEach(function(t) {
                        y(t)
                    }), delete this._observer, delete this._settings, delete this.loadingCount, delete this
                    .toLoadCount
            },
            loadAll: function(t) {
                var e = this,
                    n = this._settings;
                X(t, n).forEach(function(t) {
                    b(t, e), V(t, n, e)
                })
            },
            restoreAll: function() {
                var e = this._settings;
                Q(e).forEach(function(t) {
                    U(t, e)
                })
            }
        }, t.load = function(t, e) {
            e = i(e);
            V(t, e)
        }, t.resetStatus = function(t) {
            r(t)
        }, Z && function(t, e) {
            if (e)
                if (e.length)
                    for (var n, a = 0; n = e[a]; a += 1) o(t, n);
                else o(t, e)
        }(t, window.lazyLoadOptions), t
    });
    ! function(e, t) {
        "use strict";

        function a() {
            t.body.classList.add("litespeed_lazyloaded")
        }

        function n() {
            console.log("[LiteSpeed] Start Lazy Load Images"), d = new LazyLoad({
                elements_selector: "[data-lazyloaded]",
                callback_finish: a
            }), o = function() {
                d.update()
            }, e.MutationObserver && new MutationObserver(o).observe(t.documentElement, {
                childList: !0,
                subtree: !0,
                attributes: !0
            })
        }
        var d, o;
        e.addEventListener ? e.addEventListener("load", n, !1) : e.attachEvent("onload", n)
    }(window, document);
    </script>
    <script data-no-optimize="1">
    var litespeed_vary = document.cookie.replace(/(?:(?:^|.*;\s*)_lscache_vary\s*\=\s*([^;]*).*$)|^.*$/, "");
    litespeed_vary || fetch("/wp-content/plugins/litespeed-cache/guest.vary.php", {
        method: "POST",
        cache: "no-cache",
        redirect: "follow"
    }).then(e => e.json()).then(e => {
        console.log(e), e.hasOwnProperty("reload") && "yes" == e.reload && (sessionStorage.setItem(
            "litespeed_docref", document.referrer), window.location.reload(!0))
    });
    </script>
    <script data-optimized="1" type="litespeed/javascript"
        data-src="https://carllymotors.com/wp-content/litespeed/js/5b21c157c8217f7a3fe9a7db093ab5a0.js?ver=4d55a">
    </script>
    <script>
    const litespeed_ui_events = ["mouseover", "click", "keydown", "wheel", "touchmove", "touchstart"];
    var urlCreator = window.URL || window.webkitURL;

    function litespeed_load_delayed_js_force() {
        console.log("[LiteSpeed] Start Load JS Delayed"), litespeed_ui_events.forEach(e => {
            window.removeEventListener(e, litespeed_load_delayed_js_force, {
                passive: !0
            })
        }), document.querySelectorAll("iframe[data-litespeed-src]").forEach(e => {
            e.setAttribute("src", e.getAttribute("data-litespeed-src"))
        }), "loading" == document.readyState ? window.addEventListener("DOMContentLoaded",
            litespeed_load_delayed_js) : litespeed_load_delayed_js()
    }
    litespeed_ui_events.forEach(e => {
        window.addEventListener(e, litespeed_load_delayed_js_force, {
            passive: !0
        })
    });
    async function litespeed_load_delayed_js() {
        let t = [];
        for (var d in document.querySelectorAll('script[type="litespeed/javascript"]').forEach(e => {
                t.push(e)
            }), t) await new Promise(e => litespeed_load_one(t[d], e));
        document.dispatchEvent(new Event("DOMContentLiteSpeedLoaded")), window.dispatchEvent(new Event(
            "DOMContentLiteSpeedLoaded"))
    }

    function litespeed_load_one(t, e) {
        console.log("[LiteSpeed] Load ", t);
        var d = document.createElement("script");
        d.addEventListener("load", e), d.addEventListener("error", e), t.getAttributeNames().forEach(e => {
            "type" != e && d.setAttribute("data-src" == e ? "src" : e, t.getAttribute(e))
        });
        let a = !(d.type = "text/javascript");
        !d.src && t.textContent && (d.src = litespeed_inline2src(t.textContent), a = !0), t.after(d), t.remove(), a &&
            e()
    }

    function litespeed_inline2src(t) {
        try {
            var d = urlCreator.createObjectURL(new Blob([t.replace(/^(?:<!--)?(.*?)(?:-->)?$/gm, "$1")], {
                type: "text/javascript"
            }))
        } catch (e) {
            d = "data:text/javascript;base64," + btoa(t.replace(/^(?:<!--)?(.*?)(?:-->)?$/gm, "$1"))
        }
        return d
    }
    </script>
</body>
@endsection
