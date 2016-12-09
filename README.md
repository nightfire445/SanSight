# WebSysFinalProject
Site intended to make navigating the internet easier for visually impaired and blind users

## Install
    To install, modify config.php to reflect your system and run install.php.


## Introduction

    
### Problem
    Blind and visually impaired users need tools to navigate the internet
    Existing tools either cost money, or run on the operating system
    Developers often do not think of how accessible their site is for visually impaired users
    
    
### Solution
    SanSight is a web-based screen reader for blind people.
    No cost to use SanSight
    SanSight can be loaded from any modern browser
    Developers can load their site to examine accessibility
    
    
### Related Products
    WebAnywhere is a Web-Based Screen Reader built on PHP and other technologies. Our solution differs in technology from this application; Most notably TTS is client-side whereas WebAnywhere’s is Server Side.
    MozBraille is an in beta extension to Firefox that works with a braille terminal
    pwWebSpeak no longer officially available, but is a non-visual web browser that included a speech synthesizer
    WebbIE 4 is a text-only browser that works with screenreaders

## Design Aspects

    
### Accessible Design
    Our team researched the established guidelines/conventions for accesssible web design before implementation. Here are some of the 
    following accessible tools used in SanSight...
    
    “Spearcons": Spearcons are a sped up version of the original speech that allow listeners to pick up on hints of information 
    before the speech is spoken at a normal speed. For our application, any tag that’s not a p tag, plays a spearcon of the text 
    and then regular text.
    
    Keyboard Navigation: There's no way for blind users to know where a cursor is on a computer screen so navigating through elements
    with keyboard navigation is the best alternative method.
    
    Controllable Speech Playback: Users can control the speech playback. You can stop playback or repeat.
    
    Customizable Playback Settings: Users can control the language, rate, and pitch of the voice.
    
    
### Navigation
    While a user is listening to the speech output, they can:
    1. Tab to move through elements
    2. Ctrl to replay current element
    3. Shift to stop playing element
    4. Shift + Tab to go back through elements
    
    
### Site Structure
    Although SanSight's target users are blind people, our application still has a visual interface & site structure. SanSight has 
    a home page with instructions, an options page to change the playback settings, a history page to view sites recently visited, 
    a login page, and a registration page.


## Technical Aspects

    
### Technology Used
    1. Web Speech API (https://developer.mozilla.org/en-US/docs/Web/API/Web_Speech_API)
    This API provided the primary functionality for the SanSight web application. 
    It allowed us to bind Text-to-Speech on onFocus() events on the webpage, as well as the external webpages displayed in the iFrame. 
    It also allows for customizable options for user preference; type of voice, pitch, and speaking rate.
    
    2. PHP (http://php.net/manual/en/intro-whatis.php)
    PHP was the primary back-end language used in the implementation. 
    All SQL calls to the database were done through PDP with PDO (http://php.net/manual/en/book.pdo.php), and allowed different things 
    to be displayed on the pages depending on certian variables. Used $_SESSION to persist voice options.
    Additionally, displaying external sites and parsing these pages was also completed in PHP.
    
    3. MYSQL (https://www.mysql.com/)
    MYSQL was the database used to store all the user information in this project.
    This includes user accounts with encrypted and salted passwords and a history of pages visited.
    
    4. Javascript (https://developer.mozilla.org/en-US/docs/Web/JavaScript) and JQuery (https://jquery.com/)
    These client-side languages were primarily used to attach the Text-To-Speech feature to onFocus() events. They also defined the controls for the application, were used on the options page to populate the voice selection and preview the values selected. They also set the iframe src attribute to render the external page.
    
    6. Bootstrap
    The Boostrap framework was used on the front-end to assist in creating a sleek but simple design.
    Built in classes were used to style inputs, buttons, links, navigation bar, and postition things correctly on the pages.
    
    
### Displaying External Pages
    We used iFrames to display another HTML document within our page which kept the html valid.
    Even though they are not used often anymore, it accomplished exactly what we needed.
    All relative links were identified, and changed to absolute. 
    Hyperlinks were redirected to our site, to be displayed on the parse page again.
    Most browsers prevent requests from different domains in order to prevent malicious attacks, this is a problem for our application, we worked around this with by using file_get_contents() in php, this worked but not perfectly.
    
    
### Speech Rendering
    We used SpeechSynthesis from the Web Audio API to render speech.
    We parse the DOM identifying the tags that are supported; p, a, iframe, img, input, select are tags.
    We then set an onfocus event listener that renders the speech from the rendering cases we have defined for the element using the preferences for the speech from our options page and retreiving information from the element to pass as the text to render. 
    After which we set a tabIndex value on the element if it doesn't have one to ensure the element is focusable, value of 2 for p tags and value of 0 for other tags so users can get to the content faster.
    


### Limitations
    
#### Same Origin Policy 
    Restricts what we can do when displaying external pages.
    Some browsers don’t restrict this, but we are required to be compatible with Chrome, Firefox and Safari.
        
#### iFrames
    Some sites will block thier website from being pulled into an iframe, becuase it could be a security vulnerablity for them if we were tracking data about thier users. For example, iFrames can be used to trick a user think they're signing into a website, but the iframe site is actually stealing the username and password. We are aware that iframes may be discontinued but currently it is the easiest way to display an entire other page with valid html syntax.
        
#### Compatibility
    The web is greatly diverse in the way it displays content, and it is difficult to come up with one method to parse the whole web for the blind with only HTML. Becuase of this, our site is not compatible with many sites, and reads things in an non-optimal order in others.
    The sites we primarily target are wikis like wikipedia, so wikipedia works very well. 
        
### Future Work
    Customizable Widget Input - Allow user to customize input keys
    WAI- ARIA - Use this web standard to parse pages in a smarter way for blind users.
    Include low vision - Increase text size in iframe for low vision users
    Audio HCI
    Compatibility on more websites - Improve regular expression to change relative to absolute links. We tried many regualar expressions but ended up going with a simple one becuase it was compitible with more sites.
    Support for GET/POST requests - Allow users to do things like sign in or order things from shopping sites.
    Same Origin Policy - Use a reverse proxy to help mitigate same origin policy issues
    
    
## Use Cases

### Harry
Harry is a blind user who doesn't have enough money to buy a screen reader software. His brother Ken, heard about SanSight and sets it up for Harry. Now Harry is able to experience the web for the first time.

### Casey
Casey is a user who has partial vision due to an accident. She is still able to see webpages, but reading text is extremely difficult. SanSight is perect for her as she can click on any element on a page and hear it spoken outload.


# Final Words
Thank you very much for your work as a TA this semester. Please contact any of the team by email if you have any issues, and we'd be happy to help.
Main point of contact - Brandon Thorne (bthorne3@gmail.com)

Have a happy holidays!











