#!/usr/bin/env python3
"""Build subpages by injecting content into a shared template."""
import os
from pathlib import Path

ROOT = Path(__file__).parent
PARTIALS = ROOT / "partials"

HEAD = (PARTIALS / "head.html").read_text()
NAV  = (PARTIALS / "nav.html").read_text()
FOOT = (PARTIALS / "footer.html").read_text()

TEMPLATE = """<!doctype html>
<html lang="de">
<head>
{head}
</head>
<body>

{nav}

{content}

{footer}

</body>
</html>
"""

def build(slug: str, title: str, description: str, content: str):
    head = HEAD.replace("{{TITLE}}", title).replace("{{DESCRIPTION}}", description)
    html = TEMPLATE.format(head=head, nav=NAV, content=content, footer=FOOT)
    (ROOT / f"{slug}.html").write_text(html)
    print(f"✓ built {slug}.html")

# ============================================================
# PAGES (content is passed as argument from build_pages/*.py)
# ============================================================
if __name__ == "__main__":
    import sys
    pages_dir = ROOT / "page-contents"
    if not pages_dir.exists():
        print("No page-contents/ folder. Nothing to build.")
        sys.exit(0)

    for page_file in sorted(pages_dir.glob("*.py")):
        exec(compile(page_file.read_text(), page_file.name, "exec"),
             {"build": build, "__name__": "__main__"})
