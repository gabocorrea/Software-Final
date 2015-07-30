/**
 * Decorates another <code>SortedSet</code> to ensure it can't be altered.
 * <p>
 * This class is Serializable from Commons Collections 3.1.
 * <p>
 * Attempts to modify it will result in an UnsupportedOperationException. 
 *
 * @since Commons Collections 3.0
 * @version $Revision: 966327 $ $Date: 2010-07-21 19:39:49 +0200 (Wed, 21 Jul 2010) $
 *
 * @author Stephen Colebourne
 */
/** Serialization version */
/**
     * Factory method to create an unmodifiable set.
     * 
     * @param set  the set to decorate, must not be null
     * @throws IllegalArgumentException if set is null
     */
//-----------------------------------------------------------------------
/**
     * Write the collection out using a custom routine.
     * 
     * @param out  the output stream
     * @throws IOException
     */
/**
     * Read the collection in using a custom routine.
     * 
     * @param in  the input stream
     * @throws IOException
     * @throws ClassNotFoundException
     */
//-----------------------------------------------------------------------
/**
     * Constructor that wraps (not copies).
     * 
     * @param set  the set to decorate, must not be null
     * @throws IllegalArgumentException if set is null
     */
//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
