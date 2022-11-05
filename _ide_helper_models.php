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
 * App\Abuser
 *
 * @property int $id
 * @property string $ip
 * @property string|null $ua
 * @property string|null $nick
 * @property string|null $reason
 * @property int|null $firewall_in
 * @property string|null $deabusertime
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser query()
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereDeabusertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereFirewallIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereNick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereUa($value)
 * @mixin \Eloquent
 * @property string|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereCreatedAt($value)
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereUpdatedAt($value)
 */
	class Abuser extends \Eloquent {}
}

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
 * @property-read \App\Models\Page $page
 * @property string|null $prefix
 * @method static \Illuminate\Database\Eloquent\Builder|Comment wherePrefix($value)
 */
	class Comment extends \Eloquent {}
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
 * @mixin \Eloquent
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
 * App\Models\ArbitraryInfo
 *
 * @property int $id
 * @property string|null $user_id
 * @property string|null $tags
 * @property string|null $key
 * @property string|null $ip
 * @property string|null $related
 * @property string|null $priority
 * @property mixed|null $json
 * @property string|null $text
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereRelated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereUserId($value)
 * @mixin \Eloquent
 */
	class ArbitraryInfo extends \Eloquent {}
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
 * @property string|null $session
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereSession($value)
 */
	class LogRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\News
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $source
 * @property int|null $views
 * @property int|null $visible
 * @property int|null $added_by
 * @property string|null $content
 * @property string|null $url
 * @property string|null $category_name_old
 * @property int|null $category_id
 * @property int|null $length
 * @property string|null $deleted_at
 * @property float|null $cost
 * @property string|null $published_at
 * @property string|null $image_url
 * @property string|null $hash
 * @property string|null $description
 * @property string|null $prog_at
 * @property string|null $prog_code
 * @property int|null $prog_ok
 * @property int|null $prog_bad
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCategoryNameOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgBad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereVisible($value)
 */
	class News extends \Eloquent {}
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
 * @property float|null $cost
 * @property string|null $keywords
 * @property string|null $source_url
 * @property string|null $meta
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSourceUrl($value)
 * @property string|null $pages
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePages($value)
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Video
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $category_old_name
 * @property int|null $category_id
 * @property string|null $tags
 * @property string|null $html
 * @property float|null $length
 * @property string|null $url
 * @property string|null $description
 * @property int|null $views
 * @property string $code
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCategoryOldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereViews($value)
 */
	class Video extends \Eloquent {}
}

namespace App{
/**
 * App\NaturalLanguage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|NaturalLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NaturalLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NaturalLanguage query()
 * @mixin \Eloquent
 */
	class NaturalLanguage extends \Eloquent {}
}

namespace App{
/**
 * App\Proxy
 *
 * @property int $id
 * @property string $host
 * @property int $port
 * @property string|null $type
 * @property string $anonymity
 * @property string|null $source
 * @property string|null $speed
 * @property string|null $info
 * @property string|null $software
 * @property \Illuminate\Support\Carbon|null $checked_at
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereAnonymity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSoftware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereType($value)
 * @mixin \Eloquent
 * @property int|null $last_error
 * @property int|null $last_code
 * @property string|null $self
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereLastCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereLastError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSelf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereUpdatedAt($value)
 */
	class Proxy extends \Eloquent {}
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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *     $notifications
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

