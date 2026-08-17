( function () {
    'use strict';

    /* -------------------------------------------------------
       Lightweight markdown-like renderer for bot replies.
       Handles: **bold**, *italic*, `code`, [text](url),
                bullet lists (lines starting with - or *),
                and bare URLs.
    ------------------------------------------------------- */
    function renderMarkdown( text ) {
        // Escape HTML first to prevent XSS
        var escaped = text
            .replace( /&/g, '&amp;' )
            .replace( /</g, '&lt;' )
            .replace( />/g, '&gt;' );

        // Convert bullet list lines into <ul>/<li>
        var lines      = escaped.split( '\n' );
        var inList     = false;
        var htmlLines  = [];
        lines.forEach( function ( line ) {
            var bullet = line.match( /^[\s]*[-*]\s+(.+)$/ );
            if ( bullet ) {
                if ( ! inList ) { htmlLines.push( '<ul>' ); inList = true; }
                htmlLines.push( '<li>' + bullet[1] + '</li>' );
            } else {
                if ( inList ) { htmlLines.push( '</ul>' ); inList = false; }
                htmlLines.push( line );
            }
        } );
        if ( inList ) htmlLines.push( '</ul>' );
        var html = htmlLines.join( '\n' );

        // Inline: **bold**
        html = html.replace( /\*\*(.+?)\*\*/g, '<strong>$1</strong>' );
        // Inline: *italic* (but not **)
        html = html.replace( /(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/g, '<em>$1</em>' );
        // Inline: `code`
        html = html.replace( /`([^`]+)`/g, '<code style="background:#f3f4f6;border-radius:4px;padding:1px 5px;font-size:12px;">$1</code>' );
        // Inline: [text](url)
        html = html.replace( /\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>' );
        // Bare URLs not already inside href=""
        html = html.replace( /(?<!href=")(https?:\/\/[^\s<"]+)/g, '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>' );

        return html;
    }

    document.addEventListener( 'DOMContentLoaded', function () {
        var toggle   = document.getElementById( 'aia-toggle' );
        var win      = document.getElementById( 'aia-window' );
        var closeBtn = document.getElementById( 'aia-close' );
        var input    = document.getElementById( 'aia-input' );
        var send     = document.getElementById( 'aia-send' );
        var messages = document.getElementById( 'aia-messages' );

        if ( ! toggle || ! win || ! messages ) return;

        var history    = [];
        var sending    = false;
        var opened     = false;

        /* ----- Open / close -------------------------------- */
        function openChat() {
            win.style.display = 'flex';
            // Re-trigger pop-in animation
            win.style.animation = 'none';
            void win.offsetHeight; // reflow
            win.style.animation = '';
            input.focus();
            opened = true;
            // Hide unread badge
            var badge = toggle.querySelector( '.aia-badge' );
            if ( badge ) badge.style.display = 'none';
        }

        function closeChat() {
            win.style.display = 'none';
        }

        toggle.addEventListener( 'click', function () {
            var isHidden = win.style.display === 'none' || win.style.display === '';
            if ( isHidden ) {
                openChat();
                if ( ! opened ) showGreeting();
            } else {
                closeChat();
            }
        } );

        if ( closeBtn ) {
            closeBtn.addEventListener( 'click', closeChat );
        }

        /* ----- Greeting ------------------------------------ */
        function showGreeting() {
            var siteName = ( aiaData.siteName || '' );
            var greeting = siteName
                ? 'Hi there! 👋 Welcome to ' + siteName + '. How can I help you today?'
                : 'Hi there! 👋 How can I help you today?';
            appendBotMessage( greeting );
        }

        /* ----- Scroll to bottom ---------------------------- */
        function scrollDown() {
            messages.scrollTop = messages.scrollHeight;
        }

        /* ----- Append a bot message row -------------------- */
        function appendBotMessage( html, isHtml ) {
            var row    = document.createElement( 'div' );
            row.className = 'aia-row bot';

            var avatar = document.createElement( 'div' );
            avatar.className = 'aia-msg-avatar';
            avatar.textContent = '🤖';

            var bubble = document.createElement( 'div' );
            bubble.className = 'aia-bubble';
            if ( isHtml ) {
                bubble.innerHTML = html;
            } else {
                bubble.innerHTML = renderMarkdown( html );
            }

            row.appendChild( avatar );
            row.appendChild( bubble );
            messages.appendChild( row );
            scrollDown();
            return bubble;
        }

        /* ----- Append a user message row ------------------- */
        function appendUserMessage( text ) {
            var row    = document.createElement( 'div' );
            row.className = 'aia-row user';

            var bubble = document.createElement( 'div' );
            bubble.className = 'aia-bubble';
            bubble.textContent = text;

            var avatar = document.createElement( 'div' );
            avatar.className = 'aia-msg-avatar';
            avatar.textContent = '👤';

            row.appendChild( bubble );
            row.appendChild( avatar );
            messages.appendChild( row );
            scrollDown();
        }

        /* ----- Typing indicator ---------------------------- */
        function showTyping() {
            var row = document.createElement( 'div' );
            row.className  = 'aia-row bot';
            row.id         = 'aia-typing-row';

            var avatar = document.createElement( 'div' );
            avatar.className = 'aia-msg-avatar';
            avatar.textContent = '🤖';

            var dots = document.createElement( 'div' );
            dots.className = 'aia-typing';
            dots.innerHTML = '<span></span><span></span><span></span>';

            row.appendChild( avatar );
            row.appendChild( dots );
            messages.appendChild( row );
            scrollDown();
        }

        function hideTyping() {
            var row = document.getElementById( 'aia-typing-row' );
            if ( row ) row.parentNode.removeChild( row );
        }

        /* ----- Enable / disable input ---------------------- */
        function setInputState( enabled ) {
            input.disabled = ! enabled;
            send.disabled  = ! enabled;
        }

        /* ----- Send a message ------------------------------ */
        function sendMessage() {
            var text = input.value.trim();
            if ( ! text || sending ) return;

            sending = true;
            setInputState( false );
            appendUserMessage( text );
            history.push( { role: 'user', content: text } );
            input.value = '';

            showTyping();

            fetch( aiaData.restUrl, {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce':   aiaData.nonce
                },
                body: JSON.stringify( { history: history } )
            } )
            .then( function ( r ) {
                if ( ! r.ok ) throw new Error( 'HTTP ' + r.status );
                return r.json();
            } )
            .then( function ( data ) {
                hideTyping();
                var reply = ( data && data.reply ) ? data.reply : aiaData.i18n.error;
                appendBotMessage( reply );
                history.push( { role: 'assistant', content: reply } );
            } )
            .catch( function () {
                hideTyping();
                appendBotMessage( aiaData.i18n.error );
            } )
            .finally( function () {
                sending = false;
                setInputState( true );
                input.focus();
            } );
        }

        send.addEventListener( 'click', sendMessage );
        input.addEventListener( 'keypress', function ( e ) {
            if ( e.key === 'Enter' && ! e.shiftKey ) {
                e.preventDefault();
                sendMessage();
            }
        } );

        // Show greeting immediately on first open
        showGreeting();
    } );
} )();
