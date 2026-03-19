import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

const NAV_ITEMS = [
    { label: 'Dashboard',       icon: 'bi-speedometer2',       href: 'dashboard' },
    { label: 'Courses',         icon: 'bi-collection-play',    href: 'courses.index' },
    { label: 'My Enrollment',   icon: 'bi-journal-check',      href: 'enrollments.index' },
    { label: 'Live Classes',    icon: 'bi-camera-video',       href: 'live-classes.index' },
    { label: 'Study Materials', icon: 'bi-file-earmark-text',  href: 'materials.index' },
    { label: 'Fee Management',  icon: 'bi-cash-stack',         href: 'fees.index' },
    { label: 'Admission',       icon: 'bi-person-plus',        href: 'admissions.create' },
];

export default function LmsLayout({ children, title }) {
    const { auth } = usePage().props;
    const user = auth?.user;
    const [sidebarOpen, setSidebarOpen] = useState(true);

    return (
        <div style={{ display: 'flex', minHeight: '100vh', background: '#f3f4f6', fontFamily: "'Inter', sans-serif" }}>

            {/* ── SIDEBAR ── */}
            <aside style={{
                width: sidebarOpen ? '240px' : '64px',
                minHeight: '100vh',
                background: '#ffffff',
                borderRight: '1px solid #e5e7eb',
                display: 'flex',
                flexDirection: 'column',
                position: 'fixed',
                top: 0,
                left: 0,
                zIndex: 1040,
                transition: 'width 0.25s ease',
                overflowX: 'hidden',
                boxShadow: '2px 0 8px rgba(0,0,0,0.04)',
            }}>
                {/* Logo */}
                <div style={{
                    height: '64px',
                    display: 'flex',
                    alignItems: 'center',
                    padding: '0 16px',
                    borderBottom: '1px solid #e5e7eb',
                    gap: '10px',
                    flexShrink: 0,
                }}>
                    <div style={{
                        width: '36px', height: '36px', borderRadius: '8px',
                        background: 'linear-gradient(135deg, #3b82f6, #2563eb)',
                        display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0,
                    }}>
                        <i className="bi bi-mortarboard-fill" style={{ color: '#fff', fontSize: '16px' }}></i>
                    </div>
                    {sidebarOpen && (
                        <span style={{ fontWeight: 700, fontSize: '17px', color: '#1f2937', whiteSpace: 'nowrap', letterSpacing: '-0.3px' }}>
                            EduLMS
                        </span>
                    )}
                </div>

                {/* Navigation */}
                <nav style={{ flex: 1, padding: '12px 8px', overflowY: 'auto' }}>
                    {NAV_ITEMS.map(item => {
                        const active = typeof window !== 'undefined' && window.location.pathname === '/' + item.href.replace('.', '/');
                        return (
                            <Link
                                key={item.label}
                                href={route(item.href)}
                                style={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '10px',
                                    padding: '9px 12px',
                                    borderRadius: '6px',
                                    marginBottom: '2px',
                                    color: active ? '#2563eb' : '#6b7280',
                                    background: active ? '#eff6ff' : 'transparent',
                                    textDecoration: 'none',
                                    fontWeight: active ? 600 : 400,
                                    fontSize: '14px',
                                    whiteSpace: 'nowrap',
                                    transition: 'all 0.15s',
                                }}
                                onMouseEnter={e => { if (!active) { e.currentTarget.style.background = '#f9fafb'; e.currentTarget.style.color = '#1f2937'; } }}
                                onMouseLeave={e => { if (!active) { e.currentTarget.style.background = 'transparent'; e.currentTarget.style.color = '#6b7280'; } }}
                            >
                                <i className={`bi ${item.icon}`} style={{ fontSize: '17px', width: '20px', textAlign: 'center', flexShrink: 0 }}></i>
                                {sidebarOpen && <span>{item.label}</span>}
                            </Link>
                        );
                    })}
                </nav>

                {/* User footer */}
                {sidebarOpen && user && (
                    <div style={{ padding: '12px 16px', borderTop: '1px solid #e5e7eb', display: 'flex', alignItems: 'center', gap: '10px' }}>
                        <div style={{
                            width: '34px', height: '34px', borderRadius: '50%', flexShrink: 0,
                            background: 'linear-gradient(135deg, #3b82f6, #2563eb)',
                            display: 'flex', alignItems: 'center', justifyContent: 'center',
                            color: '#fff', fontWeight: 700, fontSize: '13px',
                        }}>
                            {user.name?.charAt(0).toUpperCase()}
                        </div>
                        <div style={{ overflow: 'hidden' }}>
                            <div style={{ fontSize: '13px', fontWeight: 600, color: '#1f2937', overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{user.name}</div>
                            <div style={{ fontSize: '11px', color: '#9ca3af', overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{user.email}</div>
                        </div>
                    </div>
                )}
            </aside>

            {/* ── MAIN CONTENT ── */}
            <div style={{ marginLeft: sidebarOpen ? '240px' : '64px', flex: 1, display: 'flex', flexDirection: 'column', transition: 'margin-left 0.25s ease', minHeight: '100vh' }}>

                {/* Blue Gradient Header */}
                <header style={{
                    background: 'linear-gradient(to right, #3b82f6, #2563eb)',
                    height: '64px',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'space-between',
                    padding: '0 24px',
                    position: 'sticky',
                    top: 0,
                    zIndex: 1030,
                    boxShadow: '0 2px 8px rgba(37,99,235,0.25)',
                }}>
                    {/* Left: toggle + page title */}
                    <div style={{ display: 'flex', alignItems: 'center', gap: '14px' }}>
                        <button
                            onClick={() => setSidebarOpen(!sidebarOpen)}
                            style={{ background: 'rgba(255,255,255,0.15)', border: 'none', borderRadius: '6px', color: '#fff', fontSize: '18px', cursor: 'pointer', padding: '5px 8px', lineHeight: 1 }}
                        >
                            <i className="bi bi-list"></i>
                        </button>
                        {title && <h1 style={{ color: '#fff', fontSize: '17px', fontWeight: 600, margin: 0 }}>{title}</h1>}
                    </div>

                    {/* Right: search + icons */}
                    <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                        <div style={{ position: 'relative' }}>
                            <i className="bi bi-search" style={{ position: 'absolute', left: '10px', top: '50%', transform: 'translateY(-50%)', color: 'rgba(255,255,255,0.7)', fontSize: '13px' }}></i>
                            <input
                                type="text"
                                placeholder="Search..."
                                style={{
                                    background: 'rgba(255,255,255,0.15)', border: '1px solid rgba(255,255,255,0.25)',
                                    borderRadius: '6px', color: '#fff', padding: '7px 12px 7px 30px',
                                    fontSize: '13px', width: '180px', outline: 'none',
                                }}
                            />
                        </div>

                        <button style={{ background: 'rgba(255,255,255,0.15)', border: 'none', borderRadius: '6px', color: '#fff', padding: '7px 10px', cursor: 'pointer', position: 'relative', fontSize: '16px' }}>
                            <i className="bi bi-bell"></i>
                            <span style={{ position: 'absolute', top: '5px', right: '5px', width: '7px', height: '7px', background: '#f59e0b', borderRadius: '50%', border: '2px solid #2563eb' }}></span>
                        </button>

                        <button style={{ background: 'rgba(255,255,255,0.15)', border: 'none', borderRadius: '6px', color: '#fff', padding: '7px 10px', cursor: 'pointer', fontSize: '16px' }}>
                            <i className="bi bi-chat-dots"></i>
                        </button>

                        <Link
                            href={route('logout')}
                            method="post"
                            as="button"
                            style={{ background: 'rgba(255,255,255,0.15)', border: '1px solid rgba(255,255,255,0.25)', borderRadius: '6px', color: '#fff', padding: '7px 12px', cursor: 'pointer', fontSize: '13px', fontWeight: 500 }}
                        >
                            <i className="bi bi-box-arrow-right me-1"></i> Logout
                        </Link>
                    </div>
                </header>

                {/* Page Content */}
                <main style={{ flex: 1, padding: '28px 24px', background: '#f3f4f6' }}>
                    {children}
                </main>
            </div>
        </div>
    );
}
