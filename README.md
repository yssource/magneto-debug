# Olctw/Debug, a toolbar for developers
Based on madalinoprea's awesome work (<https://github.com/madalinoprea/magneto-debug>),
I extended it as Olctw/Debug to improve daily jobs related to Magento.
The major differences with original one is this only for MagentoCommerce CE 1.7 or higher.
It may also work on some other versions. But currently I only focus on this one.

## INSTALLATION 
Just copy app, skin folders to your Magento working directory. If it's not working,
you should check permissions and caches first.

## FEATURES
 - Versions
    - Show lists of extensions in three pools
    - Toggle extensions on the fly
 - Performance
    - Show execution time and memory usage
    - Clear Magento Cache
 - Configuration
    - Toggle template hints and inline translation
    - Download current config as XML/Text
    - Search in configs
 - Controller
    - Information of controller for current viewing page
    - Variables of cookies, sessions, GET and POST
 - Models
    - Counter for models/queries for current page
    - List of models, collections and queries for current page
 - Layout
    - Package information
    - Handles of current request and view the full source on web
    - Sources of page layout and layout updates
 - Events
    - List of events with observers
    - List of dispatched events
 - Blocks
    - List of rendered blocks
    - List of layout blocks
 - Rewrites
    - List of all rewrites
 - Utilities
    - Search grouped classes
    - Search events
 - Logs
    - View system.log and exception.log on web

## Credits
 - Major parts of the whole tool - <https://github.com/madalinoprea/magneto-debug>
 - Rewrites pannel was inspired from <http://marius-strajeru.blogspot.tw/2013/03/get-class-rewrites.html>
 - Events pannel was merged from <https://github.com/CyprienWebDev/magneto-debug>
 - Current maintainer of this project - <http://olc.tw/en/>