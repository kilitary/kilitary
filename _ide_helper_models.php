<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Audio
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Audio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audio query()
 * @mixin \Eloquent
 */
	class Audio extends \Eloquent {}
}

namespace App{
/**
 * App\Comment
 *
 * @property int $id
 * @property int $page_id
 * @property string $comment
 * @property string $ip
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUsername($value)
 * @mixin \Eloquent
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCountry($value)
 * @property string|null $info
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereInfo($value)
 */
	class Comment extends \Eloquent {}
}

namespace App{
/**
 * App\Gay
 *
 * @property int $id
 * @property string $ip
 * @property string|null $ua
 * @property string|null $nick
 * @property string|null $reason
 * @property int|null $firewall_in
 * @property string|null $degaytime
 * @method static \Illuminate\Database\Eloquent\Builder|Gay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gay query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereDegaytime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereFirewallIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereNick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereUa($value)
 * @mixin \Eloquent
 */
	class Gay extends \Eloquent {}
}

namespace App{
/**
 * App\IpInfo
 *
 * @property int $id
 * @property string $ip
 * @property string|null $type
 * @property string|null $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereUpdatedAt($value)
 */
	class IpInfo extends \Eloquent {}
}

namespace App{
/**
 * App\Logger
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Logger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logger query()
 * @mixin \Eloquent
 */
	class Logger extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LogRecord
 *
 * @property int $id
 * @property string|null $http_code
 * @property string|null $method
 * @property string|null $url
 * @property string $ip
 * @property string|null $ua
 * @property string $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereHttpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereUa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereUrl($value)
 * @mixin \Eloquent
 * @property string|null $request_start
 * @property string|null $request_end
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereRequestEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereRequestStart($value)
 * @property string|null $referer
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereReferer($value)
 * @property-read \App\IpInfo|null $ipInfo
 */
	class LogRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $code
 * @property int $views
 * @property string $content
 * @property string $header
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereViews($value)
 * @mixin \Eloquent
 * @property int|null $edits
 * @property int|null $blocked
 * @property string $ip
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereEdits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereIp($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCountry($value)
 */
	class Page extends \Eloquent {}
}

namespace App{
/**
 * App\ShortUrl
 *
 * @property int $id
 * @property string $short
 * @property string $long
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $visits
 * @property string $creater_ip
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereCreaterIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereVisits($value)
 * @mixin \Eloquent
 */
	class ShortUrl extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

