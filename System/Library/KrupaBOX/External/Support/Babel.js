window._restoreBabel = null;
if (window.Babel !== null && window.Babel !== undefined)
    window._restoreBabel = window.Babel;



window.BabelKB = window.Babel;
window.Babel = undefined;
if (window._restoreBabel !== null)
    window.Babel = window._restoreBabel;
window._restoreBabel = undefined;