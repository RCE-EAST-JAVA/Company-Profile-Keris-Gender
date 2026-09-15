/**
 * Strips HTML tags, embed elements (iframes, scripts, etc.), and decodes common HTML entities
 * to provide a clean plain text preview for cards and snippets.
 */
export function stripHtml(html) {
    if (!html) return '';

    // Strip media embed containers and scripts
    let text = String(html)
        .replace(/<iframe[^>]*>[\s\S]*?<\/iframe>/gi, ' ')
        .replace(/<video[^>]*>[\s\S]*?<\/video>/gi, ' ')
        .replace(/<audio[^>]*>[\s\S]*?<\/audio>/gi, ' ')
        .replace(/<script[^>]*>[\s\S]*?<\/script>/gi, ' ')
        .replace(/<style[^>]*>[\s\S]*?<\/style>/gi, ' ');

    // Strip all remaining HTML tags
    text = text.replace(/<[^>]+>/g, ' ');

    // Decode common HTML entities
    text = text
        .replace(/&nbsp;/gi, ' ')
        .replace(/&amp;/gi, '&')
        .replace(/&lt;/gi, '<')
        .replace(/&gt;/gi, '>')
        .replace(/&quot;/gi, '"')
        .replace(/&#39;/gi, "'")
        .replace(/&mdash;/gi, '—')
        .replace(/&ndash;/gi, '–');

    // Collapse multiple whitespace characters into a single space and trim
    return text.replace(/\s+/g, ' ').trim();
}
