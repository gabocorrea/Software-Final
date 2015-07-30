/**
 * Decorates another <code>SortedSet</code> to transform objects that are added.
 * <p>
 * The add methods are affected by this class.
 * Thus objects must be removed or searched for using their transformed form.
 * For example, if the transformation converts Strings to Integers, you must
 * use the Integer form to remove objects.
 * <p>
 * This class is Serializable from Commons Collections 3.1.
 *
 * @since Commons Collections 3.0
 * @version $Revision: 814997 $ $Date: 2009-09-15 07:29:56 +0200 (Tue, 15 Sep 2009) $
 *
 * @author Stephen Colebourne
 */
/** Serialization version */
/**
     * Factory method to create a transforming sorted set.
     * <p>
     * If there are any elements already in the set being decorated, they
     * are NOT transformed.
     * Constrast this with {@link #decorateTransform}.
     * 
     * @param set  the set to decorate, must not be null
     * @param transformer  the transformer to use for conversion, must not be null
     * @throws IllegalArgumentException if set or transformer is null
     */
/**
     * Factory method to create a transforming sorted set that will transform
     * existing contents of the specified sorted set.
     * <p>
     * If there are any elements already in the set being decorated, they
     * will be transformed by this method.
     * Constrast this with {@link #decorate}.
     * 
     * @param set  the set to decorate, must not be null
     * @param transformer  the transformer to use for conversion, must not be null
     * @return a new transformed SortedSet
     * @throws IllegalArgumentException if set or transformer is null
     * @since Commons Collections 3.3
     */
// TODO: Generics
//-----------------------------------------------------------------------
/**
     * Constructor that wraps (not copies).
     * <p>
     * If there are any elements already in the set being decorated, they
     * are NOT transformed.
     * 
     * @param set  the set to decorate, must not be null
     * @param transformer  the transformer to use for conversion, must not be null
     * @throws IllegalArgumentException if set or transformer is null
     */
/**
     * Gets the decorated set.
     * 
     * @return the decorated set
     */
//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
