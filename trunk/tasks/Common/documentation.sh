#!/bin/bash

# Generate the actual documentation
/usr/bin/apigen --source /home/ike/public_html/ --destination /home/ike/docs/ \
    --title "AWESOMO 4000" \
    --todo yes \
    --base-url http://ike.rogierslag.nl/docs/ \
    --access-levels public,protected,private \
    --deprecated yes \
    --tree yes \
    --php yes \
    --source-code yes \
    --download no \
    --report /home/ike/docs/IKE_errors.xml \
    --exclude /home/ike/public_html/classes/class.HTMLDom.php \
    --exclude /home/ike/public_html/classes/class.PhpMailer.php \
    --exclude /home/ike/public_html/classes/exceptions \
    --exclude /home/ike/public_html/development_user
    

/usr/bin/php /home/ike/public_html/tasks/Common/processDocumentationErrors.php