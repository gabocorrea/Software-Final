/**
 * Decorates another <code>SortedSet</code> to synchronize its behaviour
 * for a multi-threaded environment.
 * <p>
 * Methods are synchronized, then forwarded to the decorated set.
 * <p>
 * This class is Serializable from Commons Collections 3.1.
 *
 * @since Commons Collections 3.0
 * @version $Revision: 815101 $ $Date: 2009-09-15 07:56:44 +0200 (Tue, 15 Sep 2009) $
 *
 * @author Stephen Colebourne
 */
/** Serialization version */
/**
     * Factory method to create a synchronized set.
     *
     * @param set  the set to decorate, must not be null
     * @throws IllegalArgumentException if set is null
     */
//-----------------------------------------------------------------------
/**
     * Constructor that wraps (not copies).
     *
     * @param set  the set to decorate, must not be null
     * @throws IllegalArgumentException if set is null
     */
/**
     * Constructor that wraps (not copies).
     *
     * @param set  the set to decorate, must not be null
     * @param lock  the lock object to use, must not be null
     * @throws IllegalArgumentException if set is null
     */
/**
     * Gets the decorated set.
     *
     * @return the decorated set
     */
//-----------------------------------------------------------------------
// the lock is passed into the constructor here to ensure that the
// subset is synchronized on the same lock as the parent
// the lock is passed into the constructor here to ensure that the
// headset is synchronized on the same lock as the parent
// the lock is passed into the constructor here to ensure that the
// tailset is synchronized on the same lock as the parent
