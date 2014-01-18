com_bw_static_cacher
====================

BWStaticCacher is a CMS Joomla! extension, which provide static caching of any pages, requested by GET method.

Installation
------------

1) Install the component `bw_static_cacher` in Control Panel via `Extensions->Extension Manager`.

2) Add to `index.php` root file next two rows at the beginning of the file after `<?php` tag:

    <?php
    require_once __DIR__ .'/components/com_bw_static_cacher/BwStaticCacher.php';
    BwStaticCacher::getInstance()->init()->find();
    // other joomla code
