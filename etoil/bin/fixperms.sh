#!/bin/sh
#
#   OpenMoney for PHP  (v0.1-cvs)
#
#   $Header: /home/xubuntu/berlios_backup/github/tmp-cvs/localis/Repository/etoil/bin/fixperms.sh,v 1.4 2005/04/04 14:29:28 vmaury Exp $
# 
#   Copyright (c) 2004 OpenMoney Community (see COPYRIGHT)
#   http://openmoney.org - http://gna.org/projects/openmoney
# 
#   This software is free software; you can redistribute it and/or
#   modify it under the terms of the GNU Lesser General Public
#   License as published by the Free Software Foundation; either
#   version 2.1 of the License, or (at your option) any later version.
# 
#   This software is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
#   Lesser General Public License for more details.
# 
#   You should have received a copy of the GNU Lesser General Public
#   License along with this software; if not, write to 
#   the Free Software Foundation, Inc., 
#   59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
# 
#

DIRS="smarty/temp www/tmp log maps"

# debian
APACHE=`ps aux | grep apache | sed -n -e 2p | cut -d' ' -f 1`
if [ -z $APACHE ]; then
	# redhat/bsd
	APACHE=`ps aux | grep httpd | sed -n -e 2p | cut -d' ' -f 1`
fi

APACHE="www-data"
# small trick to manage path
cd bin 2&> /dev/null
cd ..  2&> /dev/null

# the real job
chmod -R +r *
chown -R $USER:$APACHE $DIRS
chmod -R 02775 $DIRS

echo "Done."
exit 0

