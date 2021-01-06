import React from 'react';
import { Helmet } from 'react-helmet';
import classnames from 'classnames';
import DocumentationLink from './DocumentationLink';
import thinksterPng from '../images/thinkster.png';
import communitySvg from '../images/community.svg';
import enterpriseSvg from '../images/enterprise.svg';
import flags from '../images/flags';
import styles from './Announcements.module.scss';

const Announcements = ({ framework }) => <div className={styles['announcements']}>
    <Announcement date="Jan 6" version="25.0.0">
        <p className="card-text">
            Major release with new features and bug fixes:
        </p>
        <ul>
            <li className={styles['announcement__list-item']}>
                <DocumentationLink framework={framework} href="/server-side-model/">Major SSRM Enhancements</DocumentationLink>
            </li>
            <li className={styles['announcement__list-item']}>
                <DocumentationLink framework={framework} href="/integrated-charts-cross-filtering/">Integrated Cross Filtering</DocumentationLink>
            </li>
            <li className={styles['announcement__list-item']}>
                <DocumentationLink framework={framework} href="/clipboard/">Clipboard Performance Improvements</DocumentationLink>
            </li>
        </ul>
    </Announcement>
    <Announcement>
        <h5 className="card-title">
            <a href="https://thinkster.io/topics/ag-grid" aria-label="Thinkster"><img alt="Thinkster" style={{ width: '100%' }} src={thinksterPng} /></a>
        </h5>
        <p className="card-text">
            There are free <a href="https://thinkster.io/topics/ag-grid">Thinkster Courses</a> for learning
            ag-Grid with Angular and React.
        </p>
    </Announcement>
    <Announcement title="Best Web Grids for 2020" date="Jan 27th">
        <p className="card-text">
            ag-Grid is the "Absolute Winner" according
            to <a href="https://www.crankuptheamps.com//blog/posts/2020/01/23/grid-comparison-2/">Best Web Grids for 2020</a>.
        </p>
    </Announcement>
    <Announcement title="Community or Enterprise?">
        <img style={{ width: '30px', float: 'left', marginRight: '6px' }} src={communitySvg} alt="Community" />
        <p >
            Everyone can use ag-Grid Community for free.
            It's MIT licensed and Open Source. No restrictions. No strings attached.
        </p>
        <img style={{ width: '30px', float: 'left', marginRight: '6px' }} src={enterpriseSvg} alt="Enterprise" />
        <p>
            Do you want more features? Then <DocumentationLink framework={framework} href="/licensing/">get started with ag-Grid Enterprise</DocumentationLink>.
            You don't need to contact us to evaluate ag-Grid Enterprise. A license is only required
            when you start developing for production.
        </p>
    </Announcement>
    <Announcement title="Conferences 2020">
        <p>Come see us at the following conferences that we are attending and sponsoring.</p>

        <h6 className="card-subtitle mb-2 text-muted">Angular</h6>

        <img src={flags.us} alt="United States" className={styles['announcement__flag']} />
        <a href="https://www.ng-conf.org" target="_blank" rel="noreferrer">ng-Conf</a>
        <p className="card-subtitle mb-2 text-muted" style={{ marginTop: '1px' }}>Postponed</p>

        <img src={flags.no} alt="Norway" className={styles['announcement__flag']} />
        <a href="https://ngvikings.org" target="_blank" rel="noreferrer">ngVikings</a>
        <p className="card-subtitle mb-2 text-muted" style={{ marginTop: '1px' }}>Postponed</p>

        <img src={flags.gb} alt="United Kingdom" className={styles['announcement__flag']} />
        <a href="https://angularconnect.com" target="_blank" rel="noreferrer">Angular Connect</a>
        <p className="card-subtitle mb-2 text-muted" style={{ marginTop: '1px' }}>Oct 13-14</p>

        <p></p>

        <h6 className="card-subtitle mb-2 text-muted">React</h6>

        <img src={flags.nl} alt="Netherlands" className={styles['announcement__flag']} />
        <a href="https://reactsummit.com" target="_blank" rel="noreferrer">React Summit</a>
        <p className="card-subtitle mb-2 text-muted" style={{ marginTop: '1px' }}>11th September</p>

        <img src={flags.gb} alt="United Kingdom" className={styles['announcement__flag']} />
        <a href="https://reactadvanced.com" target="_blank" rel="noreferrer">React Advanced</a>
        <p className="card-subtitle mb-2 text-muted" style={{ marginTop: '1px' }}>Oct 25</p>

        <p></p>

        <h6 className="card-subtitle mb-2 text-muted">JavaScript</h6>

        <img src={flags.gb} alt="United Kingdom" className={styles['announcement__flag']} />
        <a href="https://halfstackconf.com/online/" target="_blank" rel="noreferrer">Half Stack Online</a>
        <p className="card-subtitle mb-2 text-muted" style={{ marginTop: '1px' }}>May 22</p>
    </Announcement>
    <MailingListSignup />
    <Announcement highlight={false}>
        <p>Work at ag-Grid:</p>
        <h5 className="card-title"><a href="/ag-grid-jobs-board/">JavaScript Developers</a></h5>
        <h6 className="card-subtitle mb-2 text-muted">London, United Kingdom</h6>
        <p className="card-text">
            Would you like to join the ag-Grid team in London?<br /><br />
            Check the <a href="/ag-grid-jobs-board/">jobs board</a>
        </p>
    </Announcement>
</div>;

const Announcement = ({ title, date, children, version, highlight = true }) => {
    return <div className={classnames(styles['announcement'], { [styles['announcement--highlighted']]: highlight })}>
        <div className="card-body">
            {version &&
                <h5 className="card-title"><a href={`/ag-grid-changelog/?fixVersion=${version}`}>Version {version}</a></h5>
            }
            {title && <h5 className="card-title">{title}</h5>}
            {date && <h6 className="card-subtitle mb-2 text-muted">{date}</h6>}
            {children}
            {version &&
                <p className="text-right">
                    <a href={`/ag-grid-changelog/?fixVersion=${version}`}>Change Log</a>
                </p>}
        </div>
    </div>;
};

const MailingListSignup = () => {
    return <>
        <Helmet>
            <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css" />
            <style type="text/css">
                {`#mc_embed_signup {
        background: #fff;
        clear: left;
        font: 14px Helvetica, Arial, sans-serif;
    }`}
            </style>
        </Helmet>
        <div id="mc_embed_signup">
            <form action="https://ag-grid.us11.list-manage.com/subscribe/post?u=9b44b788c97fa5b498fbbc9b5&amp;id=9353cf87ce"
                method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" className="validate"
                target="_blank" noValidate>
                <div id="mc_embed_signup_scroll">
                    <h2>ag-Grid Mailing List</h2>
                    <div className="mc-field-group">
                        <label htmlFor="mce-EMAIL">Email Address <span className="asterisk">*</span>
                            <input type="email" defaultValue="" name="EMAIL" className="required email" id="mce-EMAIL" />
                        </label>
                    </div>
                    <div className="mc-field-group">
                        <label htmlFor="mce-FNAME">First Name
                            <input type="text" defaultValue="" name="FNAME" id="mce-FNAME" />
                        </label>
                    </div>
                    <br />
                    <div className="mc-field-group input-group">
                        <ul>
                            <li><strong>Select your preference:</strong></li>
                            <li>
                                <label htmlFor="mce-group[18365]-18365-0">
                                    <input type="checkbox" value="1" name="group[18365][1]" id="mce-group[18365]-18365-0" /> Angular
                                </label>
                            </li>
                            <li>
                                <label htmlFor="mce-group[18365]-18365-1">
                                    <input type="checkbox" value="2" name="group[18365][2]" id="mce-group[18365]-18365-1" /> React
                                </label>
                            </li>
                            <li>
                                <label htmlFor="mce-group[18365]-18365-2">
                                    <input type="checkbox" value="4" name="group[18365][4]" id="mce-group[18365]-18365-2" /> General
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div id="mce-responses" className="clear">
                        <div className="response" id="mce-error-response" style={{ display: 'none' }}></div>
                        <div className="response" id="mce-success-response" style={{ display: 'none' }}></div>
                    </div>
                    {/* real people should not fill this in and expect good things - do not remove this or risk form bot signups */}
                    <div style={{ position: 'absolute', left: '-5000px' }} aria-hidden="true">
                        <input type="text" name="b_9b44b788c97fa5b498fbbc9b5_9353cf87ce" tabIndex="-1" defaultValue="" />
                    </div>
                    <div className="clear">
                        <input
                            type="submit"
                            style={{ backgroundColor: '#0084e7' }}
                            value="Subscribe"
                            name="subscribe"
                            id="mc-embedded-subscribe"
                            className="button" />
                    </div>
                </div>
            </form>
        </div>
        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
        <script type='text/javascript' dangerouslySetInnerHTML={{
            __html: `(function ($) {
            window.fnames = new Array();
        window.ftypes = new Array();
        fnames[0] = 'EMAIL';
        ftypes[0] = 'email';
        fnames[1] = 'FNAME';
        ftypes[1] = 'text';
        fnames[3] = 'ADDRESS';
        ftypes[3] = 'address';
        fnames[4] = 'PHONE';
        ftypes[4] = 'phone';
    }(jQuery));
    var $mcj = jQuery.noConflict(true);`}}></script>
    </>;
};

export default Announcements;
