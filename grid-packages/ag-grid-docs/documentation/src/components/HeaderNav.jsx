import React from 'react';
import { withPrefix } from 'gatsby';
import styles from './HeaderNav.module.scss';

const links = [{
    name: 'Demo',
    url: '/example.php'
}, {
    name: 'Documentation',
    url: withPrefix('/')
}, {
    name: 'Pricing',
    url: '/license-pricing.php'
}, {
    name: 'Blog',
    url: 'https://blog.ag-grid.com/?_ga=2.240961155.106872681.1607518091-965402545.1605286673'
}];

const HeaderLinks = () => (
    <ul className={styles['header-nav__navbar']}>
        { links.map(link => {
            let className = styles['header-nav__link'];
            const isDocumentation = link.url.indexOf('documentation') !== -1;

            if (isDocumentation) { className += ` ${styles.active}`; }

            return (
                <li key={link.name.toLocaleLowerCase()} className={className}>
                    <a className={styles['header-nav__link_anchor']} href={link.url}>{link.name}</a>
                </li>
            );
        })}
    </ul>
);

const HeaderExpandButton = () => (
    <button
        className={styles['header-nav__button']}
        type="button" data-toggle="collapse"
        data-target="#main-nav"
        aria-controls="main-nav"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span className={styles['header-nav__button-icon']}></span>
    </button>
);

const HeaderNav = () => (
    <nav className={styles['header-nav']}>
        <div className={styles['header-nav__wrapper']}>
            <div className={styles['header-nav__navbar-collapse']} id="main-nav">
                <HeaderLinks />
            </div>
            <div className={styles['header-nav__widgets']}>
                <HeaderExpandButton />
            </div>
        </div>
    </nav>
);

export default HeaderNav;